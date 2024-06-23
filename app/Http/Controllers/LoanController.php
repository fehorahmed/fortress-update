<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Cash;
use App\Models\Loan;
use App\Models\LoanHolder;
use App\Models\LoanPayment;
use App\Models\TransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use DataTables;

class LoanController extends Controller
{
    public function Index() {
        $banks = Bank::where('status', 1)
            ->orderBy('name')
            ->get();

        $loanHolders = LoanHolder::all();

        $loans = Loan::all();
        return view('loan.all',compact('loanHolders','loans','banks'));
    }
    public function Create() {
        $banks = Bank::where('status', 1)
            ->orderBy('name')
            ->get();
        $holders = LoanHolder::where('status',1)->get();
        return view('loan.add',compact('banks','holders'));
    }

    public function loanStore(Request $request){
        $rules = [
            'loan_holder' => 'required',
            'loan_type' => 'required',
            'payment_type' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'note' => 'nullable|string',
            'bank' => 'required_if:payment_type,==,2',
            'branch' => 'required_if:payment_type,==,2',
            'account' => 'required_if:payment_type,==,2',
            'cheque_no' => 'nullable|string|max:255',
            'cheque_date' => 'nullable|date',
            'cheque_image' => 'nullable|image',
        ];

        $request->validate($rules);
        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {

            if ($request->loan_type == 2) {
                if ($request->payment_type == 1) {
                    $cash = Cash::first();

                    if ($request->amount > $cash->amount)
                        $validator->errors()->add('amount', 'Insufficient balance.');
                }
                else {
                    if ($request->account != '') {
                        $account = BankAccount::find($request->account);

                        if ($request->amount > $account->balance)
                            $validator->errors()->add('amount', 'Insufficient balance.');
                    }
                }
            }

        });
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

            $loan = new Loan();
            $loan->loan_number= rand(000000,999999);
            $loan->project_id= Auth::user()->project_id;
            $loan->loan_holder_id = $request->loan_holder;
            $loan->loan_type = $request->loan_type;
            $loan->total = $request->amount;
            $loan->duration = $request->duration;
            $loan->date=date("Y-m-d", strtotime($request->date));
            $loan->paid=0;
            $loan->due=$request->amount;
            $loan->note=$request->note;
            $loan->save();

        $loan_holder = LoanHolder::find($request->loan_holder);

        if ($request->payment_type == 2) {

            $payment = new LoanPayment();
            $payment->type = $request->loan_type == 1 ? 1 : 3;
            $payment->loan_id = $loan->id;
            $payment->amount = $request->amount;
            $payment->bank_id = $request->bank;
            $payment->branch_id = $request->branch;
            $payment->bank_account_id = $request->account;
            $payment->cheque_no = $request->cheque_no;
            $payment->note = $request->note;
            $payment->transaction_method = $request->payment_type;
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->save();

            $image = 'img/no_image.png';

            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/loan';
                $file->move($destinationPath, $filename);

                $image = 'uploads/loan/'.$filename;
            }
            $log = new TransactionLog();
            $log->date = date("Y-m-d", strtotime($request->date));
            $log->particular = "Loan Take from ".$loan_holder->name;
            $log->transaction_type = 1;
            $log->transaction_method = $request->payment_type;
            $log->account_head_type_id = $payment->type == 1 ? 28 : 29;
            $log->account_head_sub_type_id = $payment->type == 1 ? 28 : 29;
            $log->bank_id = $request->payment_type == 2 ? $request->bank : null;
            $log->branch_id = $request->payment_type == 2 ? $request->branch : null;
            $log->bank_account_id = $request->payment_type == 2 ? $request->account : null;
            $log->cheque_no = $request->payment_type == 2 ? $request->cheque_no : null;
            $log->cheque_image = $image;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->loan_payment_id = $payment->id;
            $log->save();

            if ($payment->type == 1){
                BankAccount::where('project_id',Auth::user()->project_id)->first()
                    ->increment('balance', $request->amount);
            }else{
                BankAccount::where('project_id',Auth::user()->project_id)->first()
                    ->decrement('balance', $request->amount);
            }
        }

        if ($request->payment_type == 1) {
            $payment = new LoanPayment();
            $payment->type = $request->loan_type == 1 ? 1 : 3;
            $payment->loan_id = $loan->id;
            $payment->amount = $request->amount;
            $payment->transaction_method = $request->payment_type;
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->save();

            $log = new TransactionLog();
            $log->date = date("Y-m-d", strtotime($request->date));
            $log->particular = "Loan Take from ".$loan_holder->name;
            $log->transaction_type = 1;
            $log->transaction_method = $request->payment_type;
            $log->account_head_type_id = $payment->type == 1 ? 28 : 29;
            $log->account_head_sub_type_id = $payment->type == 1 ? 28 : 29;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->loan_payment_id = $payment->id;
            $log->save();

            if ($payment->type == 1){
                Cash::where('project_id',Auth::user()->project_id)->first()
                    ->increment('amount', $request->amount);
            }else{
                Cash::where('project_id',Auth::user()->project_id)->first()
                    ->decrement('amount', $request->amount);
            }
        }

        return redirect()->route('loan.all')->with('message', 'Loan Created successfully.');
    }

    public function loanDatatable() {

        $query = Loan::where('project_id',Auth::user()->project_id);

        return DataTables::eloquent($query)
            ->addColumn('holder', function(Loan $loan) {
                return $loan->loanHolder->name??'';
            })

            ->addColumn('action', function(Loan $loan) {
                return '<a class="btn btn-success btn-sm btn-pay" role="button" data-id="'.$loan->loan_holder_id.'" data-type-id="'.$loan->loan_type.'" data-name="'.$loan->loanHolder->name.'">Payment</a>
                        <a href="'.route('loan_details', ['loanHolder' => $loan->loan_holder_id,'type'=>$loan->loan_type]).'" class="btn btn-primary btn-sm">Details</a>';
//                        <a href="'.route('loan.edit',['loan' => $loan->loan_holder_id]).'" class="btn btn-primary btn-sm">Edit</a>';
            })

            ->addColumn('loan_type', function(Loan $loan) {
                if($loan->loan_type == 1)
                    return '<label class="label label-warning">Taken </span>';
                else
                    return '<label class="label label-primary">Given</span>';
            })
            ->editColumn('paid', function(Loan $loan) {
                return ' '.number_format($loan->paid, 2);
            })
            ->editColumn('due', function(Loan $loan) {
                return ' '.number_format($loan->due, 2);
            })
            ->editColumn('total', function(Loan $loan) {
                return ' '.number_format($loan->total, 2);
            })
            ->rawColumns(['action','loan_type'])
            ->toJson();
    }

    public function loanDetails(LoanHolder $loanHolder,$type){
        $loans = Loan::where('project_id',Auth::user()->project_id)
            ->where('loan_holder_id',$loanHolder->id)
            ->where('loan_type',$type)
            ->get();
        return view('loan.loan_details', compact('loans'));
    }

    public function loanPaymentDetails(Loan $loan,$type){

        if ($type == 2) {
            $payments = LoanPayment::where('loan_id',$loan->id)
                ->where('type',4)
                ->get();
        }else{
            $payments = LoanPayment::where('loan_id',$loan->id)
                ->where('type',2)
                ->get();
        }

        return view('loan.loan_payment_details', compact('payments'));
    }

    public function loanPaymentGetNumber(Request $request) {
        $loans = Loan::where('loan_holder_id', $request->holderId)
            ->where('due', '>', 0)
            ->get()->toArray();
        return response()->json($loans);
    }

    public function loanPaymentOrderDetails(Request $request){
        $loan = Loan::where('id', $request->loanId)
            ->first()->toArray();

        return response()->json($loan);
    }

    public function makePayment(Request $request) {

        $rules = [
            'loan_id' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ];
        if ($request->payment_type == '2') {
            $rules['bank'] = 'required';
            $rules['branch'] = 'required';
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        $loan = Loan::find($request->loan_id);
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        // return "Work";
        $loan_holder = LoanHolder::where('id', $request->loan_holder_id)->first();


        if ($request->payment_type == 1 ) {
            $payment = new LoanPayment();
            $payment->type = $request->loan_type_id == 1 ? 2 : 4;
            $payment->loan_id = $request->loan_id;
            $payment->amount = $request->amount;
            $payment->due = $loan->due -$request->amount;
            $payment->transaction_method = $request->payment_type;
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->save();


        }else {
            $image = 'img/no_image.png';

            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString().'.'.$file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/loan';
                $file->move($destinationPath, $filename);

                $image = 'uploads/loan/'.$filename;
            }
            $payment = new LoanPayment();
            $payment->type = $request->loan_type_id == 1 ? 2 : 4;
            $payment->loan_id = $request->loan_id;
            $payment->amount = $request->amount;
            $payment->due = $loan->due - $request->amount;
            $payment->bank_id = $request->bank;
            $payment->branch_id = $request->branch;
            $payment->bank_account_id = $request->account;
            $payment->cheque_no = $request->cheque_no;
            $payment->note = $request->note;
            $payment->transaction_method = $request->payment_type;
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->save();

        }


        $loan->increment('paid', $request->amount);
        $loan->decrement('due', $request->amount);


//        return response()->json(['success' => true, 'message' => 'Payment has been completed.', 'redirect_url' => route('loan_payment_print',['payment'=>$payment->id])]);
        return response()->json(['success' => true, 'message' => 'Payment has been completed.', 'redirect_url' => route('loan.all')]);

    }
}
