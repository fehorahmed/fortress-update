<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Cash;
use App\Models\ContractorBudget;
use App\Models\ContractorPayment;
use App\Models\MobileBanking;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Contractor;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use App\Models\TransactionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use SakibRahaman\DecimalToWords\DecimalToWords;

class ContractorController extends Controller
{
    public function index() {
        $contractors = Contractor::where('project_id',Auth::user()->project_id)->get();
        return view('purchase.contractor.all', compact('contractors'));
    }

    public function add() {
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        return view('purchase.contractor.add',compact('projects'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            //'project' => 'required',
            'company_name' => 'nullable|string|max:255',
            'mobile' => 'required|digits:11',
            'alternative_mobile' => 'nullable|digits:11',
            'email' => 'nullable|email|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $supplier = new Contractor();
        $supplier->name = $request->name;
        $supplier->project_id = Auth::user()->project_id??'';
        $supplier->company_name = $request->company_name;
        $supplier->mobile = $request->mobile;
        $supplier->alternative_mobile = $request->alternative_mobile;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->status = $request->status;
        $supplier->save();

        return redirect()->route('contractor')->with('message', 'Contractor add successfully.');
    }

    public function edit(Contractor $contractor) {
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        return view('purchase.contractor.edit', compact('contractor','projects'));
    }

    public function editPost(Contractor $contractor, Request $request) {
        $request->validate([
            //'project' => 'required',
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'mobile' => 'required|digits:11',
            'alternative_mobile' => 'nullable|digits:11',
            'email' => 'nullable|email|string|max:255',
            'address' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $contractor->name = $request->name;
        $contractor->project_id = Auth::user()->project_id??'';
        $contractor->company_name = $request->company_name;
        $contractor->mobile = $request->mobile;
        $contractor->alternative_mobile = $request->alternative_mobile;
        $contractor->email = $request->email;
        $contractor->address = $request->address;
        $contractor->status = $request->status;
        $contractor->save();

        return redirect()->route('contractor')->with('message', 'Contractor edit successfully.');
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
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->orderBy('name')->get();
        $bankAccounts = BankAccount::where('project_id',Auth::user()->project_id)->where('status', 1)->get();
        return view('purchase.contractor_payment.all', compact('contractors', 'bankAccounts', 'segments'));
    }

    public function contractorPaymentAll(Contractor $contractor)
    {
        return view('purchase.contractor_payment.contractor_payment_details', compact('contractor'));
    }

    public function contractorPaymentDetails(ContractorPayment $payment)
    {
        $payment->amount_in_word = DecimalToWords::convert(
            $payment->amount,
            'Taka',
            'Poisa'
        );
        return view('purchase.contractor_receipt.payment_details', compact('payment'));
    }

    public function contractorPaymentEdit(ContractorPayment $payment){
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->orderBy('name')->get();
        $bankAccounts = BankAccount::where('project_id',Auth::user()->project_id)->get();
        return view('purchase.contractor_payment.contractor_payment_edit', compact('segments','bankAccounts','payment'));
    }

    public function contractorPaymentEditPostOld(ContractorPayment $payment, Request $request) {
//        dd($request->all());
        $rules = [
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ];

        if ($request->payment_type == '2') {
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->account != '') {
            $account = BankAccount::find($request->account);
        }

        if ($payment->transaction_method == 2) {
            $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id', $request->account)->first();
            $bankAccount->decrement('balance', $payment->amount);
        } elseif ($payment->transaction_method == 1) {
            Cash::where('project_id',Auth::user()->project_id)
                ->decrement('amount', $payment->amount);
        }
        TransactionLog::where('contractor_payment_id',$payment->id)->delete();
        $payment->delete();

        $contractorPayment = new ContractorPayment();
        $contractorPayment->contractor_id = $payment->contractor_id;
        $contractorPayment->project_id = Auth::user()->project_id;
        $contractorPayment->segment_id = $request->segment;
        $contractorPayment->received_type = 1; //1=nogod, 2=due
        $contractorPayment->type = 1; //1=payment
        $contractorPayment->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $contractorPayment->bank_id = $account->bank_id;
            $contractorPayment->branch_id = $account->branch_id;
            $contractorPayment->bank_account_id = $account->id;
            $contractorPayment->cheque_no = $request->cheque_no;
            $image = '';

            $image = 'img/no_image.png';
            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/purchase_payment_cheque';
                $file->move($destinationPath, $filename);
                $image = 'uploads/purchase_payment_cheque/' . $filename;
            }
            $contractorPayment->cheque_image = $image;
        }
        $contractorPayment->amount = $request->amount; //Total
        $contractorPayment->date = date('Y-m-d');
        $contractorPayment->note = $request->note;
        $contractorPayment->user_id = Auth::id();
        $contractorPayment->save();
        $contractorPayment->id_no = $payment->id_no;
        $contractorPayment->save();

        $log = new TransactionLog();
        $log->particular = 'Paid to ' . $payment->contractor->name . ' for Purchase no. ' . $payment->id_no;
        $log->date = date('Y-m-d');
        $log->contractor_payment_id = $contractorPayment->id;
        $log->contractor_id = $payment->contractor_id;
        $log->project_id = Auth::user()->project_id;
        $log->product_segment_id = $request->segment;
        $log->transaction_type = 2; //1=Income; 2=Expense;
        $log->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
        }
        $log->account_head_type_id = 2;
        $log->account_head_sub_type_id = 2;
        $log->amount = $request->amount;
        $log->note = $request->note;
        $log->user_id = Auth::id();
        $log->save();

        if ($request->payment_type == 2) {
            $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id', $request->account)->first();
            $bankAccount->increment('balance', $request->amount);
        } elseif ($request->payment_type == 1) {
            Cash::where('project_id',Auth::user()->project_id)->increment('amount', $request->amount);
        }

        return redirect()->route('contractor_payment.all');
    }

    public function contractorPaymentEditPost(ContractorPayment $payment, Request $request) {
        $rules = [
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ];

        if ($request->payment_type == '2') {
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->account != '') {
            $account = BankAccount::find($request->account);
        }

        $checkAmount = 0;

        if($request->amount > $payment->amount){
            $checkAmount = ($request->amount - $payment->amount);

            $validator->after(function ($validator) use ($request,$checkAmount) {
                if ($request->payment_type == 1) {
                    $cash = Cash::where('project_id',Auth::user()->project_id)->first();

//                    if ($checkAmount > $cash->amount)
//                        $validator->errors()->add('amount', 'Insufficient balance.');
                } else {
                    $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                        ->where('id',$request->account)->first();

//                    if ($checkAmount > $bankAccount->balance)
//                        $validator->errors()->add('amount', 'Insufficient balance.');
                }
            });
        }

        // Cash and Bank amount increment as previous amount delete
        if ($payment->transaction_method == 1){
            $cash = Cash::where('project_id',Auth::user()->project_id)->first();
            if ($cash){
                $cash->increment('amount',$payment->amount);
            }
        }else{
            $account = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id',$request->account)->first();
            if ($account){
                $account->increment('balance', $payment->amount);
            }
        }

        TransactionLog::where('contractor_payment_id',$payment->id)->delete();
        $payment->delete();

        if($request->account != ''){
            $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id',$request->account)->first();
        }

        $contractorPayment = new ContractorPayment();
        $contractorPayment->contractor_id = $payment->contractor_id;
        $contractorPayment->project_id = Auth::user()->project_id;
        $contractorPayment->segment_id = $request->segment;
        $contractorPayment->received_type = 1; //1=nogod, 2=due
        $contractorPayment->type = 1; //1=payment
        $contractorPayment->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $contractorPayment->bank_id = $account->bank_id;
            $contractorPayment->branch_id = $account->branch_id;
            $contractorPayment->bank_account_id = $account->id;
            $contractorPayment->cheque_no = $request->cheque_no;
            $image = '';

            $image = 'img/no_image.png';
            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/purchase_payment_cheque';
                $file->move($destinationPath, $filename);
                $image = 'uploads/purchase_payment_cheque/' . $filename;
            }
            $contractorPayment->cheque_image = $image;
        }
        $contractorPayment->amount = $request->amount; //Total
        $contractorPayment->date = $request->date;
        $contractorPayment->note = $request->note;
        $contractorPayment->user_id = Auth::id();
        $contractorPayment->save();
        $contractorPayment->id_no = $payment->id_no;
        $contractorPayment->save();


        // Cash and Bank amount decrement
        if ($request->payment_type == 1) {
            Cash::where('project_id',Auth::user()->project_id)->decrement('amount', $request->amount);
        }else {
            BankAccount::where('id',$request->account)->where('project_id',Auth::user()->project_id)->decrement('balance', $request->amount);
        }

        $log = new TransactionLog();
        $log->particular = 'Paid to ' . $payment->contractor->name . ' for Purchase no. ' . $payment->id_no;
        $log->date = $request->date;
        $log->contractor_payment_id = $contractorPayment->id;
        $log->contractor_id = $payment->contractor_id;
        $log->project_id = Auth::user()->project_id;
        $log->product_segment_id = $request->segment;
        $log->transaction_type = 2; //1=Income; 2=Expense;
        $log->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
        }
        $log->account_head_type_id = 2;
        $log->account_head_sub_type_id = 2;
        $log->amount = $request->amount;
        $log->note = $request->note;
        $log->user_id = Auth::id();
        $log->save();
        return redirect()->route('contractor_payment.all');
    }


    public function contractorPaymentGetOrders(Request $request){
        $segments = ContractorBudget::where('contractor_id', $request->contractorId)
            ->with('segment','project')
            ->where('due', '>', 0)
            ->get()->toArray();
        return response()->json($segments);
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
        $order = ContractorBudget::where('id', $request->supplierId)
            ->first()->toArray();

        return response()->json($order);
    }

    public function makePayment(Request $request)
    {
        $rules = [
            'segment' => 'required',
            'project' => 'required',
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

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if ($request->payment_type == 1) {
                $cash = Cash::where('project_id',Auth::user()->project_id)->first();


//                if ($request->amount > $cash->amount)
//                    $validator->errors()->add('amount', 'Insufficient balance.');
            } else {
                if ($request->account != '') {
                    $account = BankAccount::where('project_id',Auth::user()->project_id)->first();
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

        $order = ContractorBudget::find($request->project);

        if ($request->payment_type == 1 || $request->payment_type == 3) {
            $payment = new ContractorPayment();
            $payment->project_id = $order->project_id;
            $payment->contractor_id = $order->contractor_id;
            $payment->segment_id = $request->segment;
            $payment->transaction_method = $request->payment_type;
            $payment->amount = $request->amount;
            $payment->type = 1;
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->note = $request->note;
            $payment->user_id = Auth::id();
            $payment->save();
            $payment->id_no= 10000 + $payment->id;
            $payment->save();

            if ($request->payment_type == 1)
                Cash::where('project_id',Auth::user()->project_id)->decrement('amount', $request->amount);
            else
                MobileBanking::where('project_id',Auth::user()->project_id)->decrement('amount', $request->amount);

            $log = new TransactionLog();
            $log->date = date("Y-m-d", strtotime($request->date));
            $log->contractor_id = $order->contractor_id;
            $log->project_id = $order->project_id;
            $log->product_segment_id = $request->segment;
            $log->particular = 'Paid to ' . $order->contractor->name . ' for Purchase no. ' . $order->order_no;
            $log->transaction_type = 2;   //Expense
            $log->transaction_method = $request->payment_type;
            $log->account_head_type_id = 27;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->user_id = Auth::id();
            $log->contractor_payment_id = $payment->id;
            $log->save();
        } else {
            $image = 'img/no_image.png';

            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/contractor_payment_cheque';
                $file->move($destinationPath, $filename);

                $image = 'uploads/contractor_payment_cheque/' . $filename;
            }

            $payment = new ContractorPayment();
            $payment->contractor_id = $order->contractor_id;
            $payment->project_id = $order->project_id;
            $payment->segment_id = $request->segment;
            $payment->transaction_method = 2;  //bank
            $payment->bank_id = $account->bank_id;
            $payment->branch_id = $account->branch_id;
            $payment->bank_account_id = $account->id;
            $payment->cheque_no = $request->cheque_no;
            $payment->cheque_image = $image;
            $payment->type = 1;
            $payment->amount = $request->amount;
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->note = $request->note;
            $payment->user_id = Auth::id();
            $payment->save();
            $payment->id_no= 10000 + $payment->id;
            $payment->save();

            BankAccount::where('id',$request->account)->where('project_id',Auth::user()->project_id)->decrement('balance', $request->amount);

            $log = new TransactionLog();
            $log->date = date("Y-m-d", strtotime($request->date));
            $log->contractor_id = $order->contractor_id;
            $log->project_id = $order->project_id;
            $log->product_segment_id = $request->segment;
            $log->particular = 'Paid to ' . $order->contractor->name . ' for Purchase no. ' . $order->order_no;
            $log->transaction_type = 2;
            $log->transaction_method = 2;
            $log->account_head_type_id = 27;
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->user_id = Auth::id();
            $log->contractor_payment_id = $payment->id;
            $log->save();
        }

        $order->increment('paid', $request->amount);
        $order->decrement('due', $request->amount);

        return response()->json(['success' => true, 'message' => 'Payment has been completed.', 'redirect_url' => route('contractor_receipt.payment_details', ['payment' => $payment->id])]);
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
            $log->particular = 'Refund from ' . $order->contractor->name . ' for ' . $order->order_no;
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
            $log->particular = 'Refund from ' . $order->contractor->name . ' for ' . $order->order_no;
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

    public function purchasePaymentDetails(PurchasePayment $payment)
    {
        $payment->amount_in_word = DecimalToWords::convert(
            $payment->amount,
            'Taka',
            'Poisa'
        );
        return view('purchase.receipt.payment_details', compact('payment'));
    }

    public function purchasePaymentPrint(PurchasePayment $payment)
    {
        $payment->amount_in_word = DecimalToWords::convert(
            $payment->amount,
            'Taka',
            'Poisa'
        );
        return view('purchase.receipt.payment_print', compact('payment'));
    }
}
