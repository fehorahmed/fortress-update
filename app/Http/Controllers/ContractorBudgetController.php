<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Cash;
use App\Models\Contractor;
use App\Models\ContractorBudget;
use App\Models\MobileBanking;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ContractorBudgetController extends Controller
{
    public function index() {
        $contractors = ContractorBudget::where('project_id',Auth::user()->project_id)->get();
//        dd($contractors);
        return view('purchase.contractor_budget.all', compact('contractors'));
    }

    public function add() {
        $contractors = Contractor::where('project_id',Auth::user()->project_id)->get();
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->get();

        return view('purchase.contractor_budget.add',compact('projects','contractors','segments'));
    }

    public function addPost(Request $request) {
//        dd($request->all());
        $request->validate([
            'contractor' => 'required',
            'segment' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = ContractorBudget::where('contractor_id', $request->contractor)
                        ->where('segment_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail('The selected segment has already been added for this contractor.');
                    }
                }
            ],
            'budget' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $contractor = new ContractorBudget();
        $contractor->contractor_id = $request->contractor;
        $contractor->segment_id = $request->segment;
        $contractor->project_id = Auth::user()->project_id??'';
        $contractor->total = $request->budget;
        $contractor->due = $request->budget;
        $contractor->status = $request->status;
        $contractor->save();

        return redirect()->route('contractor_budget')->with('message', 'Contractor budget added successfully.');
    }

    public function edit(ContractorBudget $contractorBudget) {
        $contractors = Contractor::where('project_id',Auth::user()->project_id)->get();
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->get();

        return view('purchase.contractor_budget.edit', compact('contractorBudget','projects','contractors','segments'));
    }

    public function editPost(ContractorBudget $contractorBudget, Request $request) {
        $request->validate([
            'contractor' => 'required',
            'segment' => [
                'required',
                function ($attribute, $value, $fail) use ($request, $contractorBudget) {
                    if ($value != $contractorBudget->segment_id) {
                        $exists = ContractorBudget::where('contractor_id', $request->contractor)
                            ->where('segment_id', $value)
                            ->exists();
                        if ($exists) {
                            $fail('The selected segment has already been added for this contractor.');
                        }
                    }
                }
            ],
            'budget' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $contractorBudget->contractor_id = $request->contractor;
        $contractorBudget->project_id = Auth::user()->project_id??'';
        $contractorBudget->segment_id = $request->segment;
        $contractorBudget->total = $request->budget;
        $contractorBudget->due = $request->budget;
        $contractorBudget->status = $request->status;
        $contractorBudget->save();

        return redirect()->route('contractor_budget')->with('message', 'Contractor budget edit successfully.');
    }

    public function contractorLedger(Request $request){

        $contractors = Contractor::where('project_id',Auth::user()->project_id)->orderBy('name')->get();
        $appends = [];
        $query = PurchaseOrder::where('project_id',Auth::user()->project_id);

        if ($request->start && $request->end) {
            $query->whereBetween('date', [$request->start, $request->end]);
            $appends['date'] = $request->date;
        }

        if ($request->contractor && $request->contractor != '') {
            $query->where('contractor_id', $request->contractor);
            $appends['contractor'] = $request->contractor;
        }
        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
        $orders = $query->get();
        return view('report.contractor_ledger',compact('contractors','orders','appends'));
    }

    public function contractorPayment()
    {
        $contractors = Contractor::where('project_id',Auth::user()->project_id)->get();
        $bankAccounts = BankAccount::where('project_id',Auth::user()->project_id)->where('status', 1)->get();
        return view('purchase.contractor_payment.all', compact('contractors', 'bankAccounts'));
    }

    public function contractorPaymentDetails(Contractor $contractor)
    {
        return view('purchase.contractor_payment.contractor_payment_details', compact('contractor'));
    }

    public function contractorPaymentGetOrders(Request $request)
    {
        $orders = PurchaseOrder::where('supplier_id', $request->supplierId)
            ->where('due', '>', 0)
            ->orderBy('order_no')
            ->get()->toArray();

        return response()->json($orders);
    }

    public function contractorPaymentGetRefundOrders(Request $request)
    {
        $orders = PurchaseOrder::where('supplier_id', $request->supplierId)
            ->where('refund', '>', 0)
            ->orderBy('order_no')
            ->get()->toArray();

        return response()->json($orders);
    }

    public function contractorPaymentOrderDetails(Request $request)
    {
        $order = PurchaseOrder::where('id', $request->orderId)
            ->first()->toArray();

        return response()->json($order);
    }

    public function makePayment(Request $request)
    {
        $rules = [
            'order' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ];

        if ($request->payment_type == '2') {
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        if ($request->order != '') {
            $order = PurchaseOrder::find($request->order);
            $rules['amount'] = 'required|numeric|min:0|max:' . $order->due;
        }

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->payment_type == 1) {
                $cash = Cash::first();

//                if ($request->amount > $cash->amount)
//                    $validator->errors()->add('amount', 'Insufficient balance.');
            } else {
                if ($request->account != '') {
                    $account = BankAccount::find($request->account);
//                    if ($request->amount > $account->balance)
//                        $validator->errors()->add('amount', 'Insufficient balance.');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->account != '') {
            $account = BankAccount::find($request->account);
        }

        $order = PurchaseOrder::find($request->order);

        if ($request->payment_type == 1 || $request->payment_type == 3) {
            $payment = new PurchasePayment();
            $payment->purchase_order_id = $order->id;
            $payment->project_id = $order->project_id;
            $payment->supplier_id = $order->supplier_id;
            $payment->transaction_method = $request->payment_type;
            $payment->amount = $request->amount;
            $payment->type = 1;
            $payment->date = $request->date;
            $payment->note = $request->note;
            $payment->user_id = Auth::id();
            $payment->save();
            $payment->id_no= 10000 + $payment->id;
            $payment->save();

            if ($request->payment_type == 1)
                Cash::first()->decrement('amount', $request->amount);
            else
                MobileBanking::first()->decrement('amount', $request->amount);

            $log = new TransactionLog();
            $log->date = $request->date;
            $log->supplier_id = $order->supplier_id;
            $log->project_id = $order->project_id;
            $log->particular = 'Paid to ' . $order->supplier->name . ' for Purchase no. ' . $order->order_no;
            $log->transaction_type = 2;   //Expense
            $log->transaction_method = $request->payment_type;
            $log->account_head_type_id = 1;
            $log->account_head_sub_type_id = 1;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->user_id = Auth::id();
            $log->purchase_payment_id = $payment->id;
            $log->save();
        } else {
            $image = 'img/no_image.png';

            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/purchase_payment_cheque';
                $file->move($destinationPath, $filename);

                $image = 'uploads/purchase_payment_cheque/' . $filename;
            }

            $payment = new PurchasePayment();
            $payment->purchase_order_id = $order->id;
            $payment->supplier_id = $order->supplier_id;
            $payment->project_id = $order->project_id;
            $payment->transaction_method = 2;  //bank
            $payment->bank_id = $account->bank_id;
            $payment->branch_id = $account->branch_id;
            $payment->bank_account_id = $account->id;
            $payment->cheque_no = $request->cheque_no;
            $payment->cheque_image = $image;
            $payment->type = 1;
            $payment->amount = $request->amount;
            $payment->date = $request->date;
            $payment->note = $request->note;
            $payment->user_id = Auth::id();
            $payment->save();
            $payment->id_no= 10000 + $payment->id;
            $payment->save();

            BankAccount::find($request->account)->decrement('balance', $request->amount);

            $log = new TransactionLog();
            $log->date = $request->date;
            $log->supplier_id = $order->supplier_id;
            $log->project_id = $order->project_id;
            $log->particular = 'Paid to ' . $order->supplier->name . ' for Purchase no. ' . $order->order_no;
            $log->transaction_type = 2;
            $log->transaction_method = 2;
            $log->account_head_type_id = 1;
            $log->account_head_sub_type_id = 1;
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->user_id = Auth::id();
            $log->purchase_payment_id = $payment->id;
            $log->save();
        }

        $order->increment('paid', $request->amount);
        $order->decrement('due', $request->amount);

        return response()->json(['success' => true, 'message' => 'Payment has been completed.', 'redirect_url' => route('purchase_receipt.payment_details', ['payment' => $payment->id])]);
    }

    public function makeRefund(Request $request)
    {

        $rules = [
            'order' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ];

        if ($request->payment_type == '2') {
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        if ($request->order != '') {
            $order = PurchaseOrder::find($request->order);
            $rules['amount'] = 'required|numeric|min:0|max:' . $order->refund;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->account != '') {
            $account = BankAccount::find($request->account);
        }

        $order = PurchaseOrder::find($request->order);

        if ($request->payment_type == 1 || $request->payment_type == 3) {
            $payment = new PurchasePayment();
            $payment->purchase_order_id = $order->id;
            $payment->supplier_id = $order->supplier_id;
            $payment->type = 2;
            $payment->transaction_method = $request->payment_type;
            $payment->amount = $request->amount;
            $payment->date = $request->date;
            $payment->note = $request->note;
            $payment->save();

            if ($request->payment_type == 1)
                Cash::first()->increment('amount', $request->amount);
            else
                MobileBanking::first()->increment('amount', $request->amount);

            $log = new TransactionLog();
            $log->date = $request->date;
            $log->particular = 'Refund from ' . $order->supplier->name . ' for ' . $order->order_no;
            $log->transaction_type = 5;
            $log->transaction_method = $request->payment_type;
            $log->account_head_type_id = 7;
            $log->account_head_sub_type_id = 7;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->purchase_payment_id = $payment->id;
            $log->save();
        } else {
            $image = 'img/no_image.png';

            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/purchase_payment_cheque';
                $file->move($destinationPath, $filename);

                $image = 'uploads/purchase_payment_cheque/' . $filename;
            }

            $payment = new PurchasePayment();
            $payment->purchase_order_id = $order->id;
            $payment->supplier_id = $order->supplier_id;
            $payment->type = 2;
            $payment->transaction_method = 2;
            $payment->bank_id = $account->bank_id;
            $payment->branch_id = $account->branch_id;
            $payment->bank_account_id = $account->id;
            $payment->cheque_no = $request->cheque_no;
            $payment->cheque_image = $image;
            $payment->amount = $request->amount;
            $payment->date = $request->date;
            $payment->note = $request->note;
            $payment->save();

            BankAccount::find($request->account)->increment('balance', $request->amount);

            $log = new TransactionLog();
            $log->date = $request->date;
            $log->particular = 'Refund from ' . $order->supplier->name . ' for ' . $order->order_no;
            $log->transaction_type = 5;
            $log->transaction_method = 2;
            $log->account_head_type_id = 7;
            $log->account_head_sub_type_id = 7;
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->purchase_payment_id = $payment->id;
            $log->save();
        }

        $order->decrement('refund', $request->amount);
        $order->decrement('paid', $request->amount);

        return response()->json(['success' => true, 'message' => 'Refund has been completed.', 'redirect_url' => route('purchase_receipt.payment_details', ['payment' => $payment->id])]);
    }
}
