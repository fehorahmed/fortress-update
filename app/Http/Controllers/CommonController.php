<?php

namespace App\Http\Controllers;

use App\Models\AccountHeadSubType;
use App\Models\AccountHeadType;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Costing;
use App\Models\CostingSegment;
use App\Models\ProductPurchaseOrder;
use App\Models\ProductRequisition;
use App\Models\ProductSegment;
use App\Models\ProjectWiseStakeholder;
use App\Models\PurchaseInventory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductProductCosting;
use App\Models\Requisition;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    public function getBranch(Request $request)
    {
        $branches = Branch::where('bank_id', $request->bankId)
            ->where('status', 1)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($branches);
    }
    public function getBank(Request $request){

        $banks = Bank::where('project_id',$request->projectId)
            ->where('status', 1)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($banks);

    }
    public function orderDetails(Request $request)
    {
        $order = SalesOrder::where('id', $request->orderId)->with('client')->first()->toArray();

        return response()->json($order);
    }
    public function getBankAccount(Request $request)
    {
        $accounts = BankAccount::where('branch_id', $request->branchId)
            ->where('status', 1)
            ->orderBy('account_no')
            ->get()->toArray();

        return response()->json($accounts);
    }

    public function getAccountHeadType(Request $request)
    {
        $types = AccountHeadType::where('transaction_type', $request->type)
            ->where('status', 1)
            ->where('project_id', Auth::user()->project_id)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($types);
    }
    public function getAccountHeadTypeTrx(Request $request)
    {
        $types = AccountHeadType::where('transaction_type', $request->type)
            ->where('status', 1)
            ->whereNotIn('id', [1, 2, 3, 4, 5, 6])
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($types);
    }

    public function getAccountHeadSubType(Request $request)
    {
        $subTypes = AccountHeadSubType::where('account_head_type_id', $request->typeId)
            ->where('status', 1)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($subTypes);
    }
    public function getAccountHeadSubTypeTrx(Request $request)
    {
        $subTypes = AccountHeadSubType::where('account_head_type_id', $request->typeId)
            ->where('status', 1)
            ->whereNotIn('id', [1, 2, 3, 4, 5, 6])
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($subTypes);
    }

    public function getSegment(Request $request)
    {
        $segments = ProductSegment::where('status', 1)->where('project_id', $request->projectId)->get();
        return response()->json($segments);
    }
    public function getRequisitionId(Request $request)
    {
        $segments = Requisition::where('product_segment_id', $request->segmentId)
            ->where('project_id', Auth::user()->project_id)
            ->get();
       // dd($segments);
        return response()->json($segments);
    }

    public function getCostingSegment(Request $request)
    {
        $segmentIds = Costing::where('estimate_project_id', $request->projectId)->pluck('costing_type_id');
         //dd($segmentIds);
        $segments = ProductSegment::where('status', 1)
            ->whereNotIn('id', $segmentIds)
            ->where('project_id', $request->projectId)->get();
        //dd($segments);
        return response()->json($segments);
    }

    public function getSegmentData(Request $request)
    {
        $segments = ProductSegment::find($request->segmentId);
        // dd($segments);
        return response()->json($segments);
    }


    public function getDesignation(Request $request)
    {
        $designations = Designation::where('department_id', $request->departmentId)
            ->where('status', 1)
            ->orderBy('name')->get()->toArray();

        return response()->json($designations);
    }

    public function getEmployeeDetails(Request $request)
    {
        $employee = Employee::where('id', $request->employeeId)
            ->with('department', 'designation')->first();

        return response()->json($employee);
    }

    public function getMonth(Request $request)
    {
        $salaryProcess = SalaryProcess::select('month')
            ->where('year', $request->year)
            ->get();

        $proceedMonths = [];
        $result = [];

        foreach ($salaryProcess as $item)
            $proceedMonths[] = $item->month;

        for ($i = 1; $i <= 12; $i++) {
            if (!in_array($i, $proceedMonths)) {
                $result[] = [
                    'id' => $i,
                    'name' => date('F', mktime(0, 0, 0, $i, 10)),
                ];
            }
        }

        return response()->json($result);
    }
    public function getMonthSalaryMonth(Request $request)
    {

        $salaryProcess = SalaryProcess::select('month')
            ->where('year', $request->year)
            ->get();

        $proceedMonths = [];
        $result = [];

        foreach ($salaryProcess as $item)
            $proceedMonths[] = $item->month;

        for ($i = 1; $i <= 12; $i++) {
            if (in_array($i, $proceedMonths)) {
                $result[] = [
                    'id' => $i,
                    'name' => date('F', mktime(0, 0, 0, $i, 10)),
                ];
            }
        }

        return response()->json($result);
    }

    public function getCashInfo(Request $request)
    {
        $cash = Cash::where('project_id',$request->projectId)->first();
        return response()->json($cash);
    }
    public function getBankAmountInfo(Request $request)
    {
        $balance = BankAccount::where('project_id',$request->projectId)->sum('balance');
        return response()->json($balance);
    }
    public function cash()
    {
        $cashes = Cash::where('project_id',Auth::user()->project_id)->get();
        return view('cash.all', compact('cashes'));
    }
    public function cashAdd(){
        return view('cash.add_info');
    }
    public function cashStore(Request $request){
        // dd($request->all());
        $cash = new Cash();
        $cash->project_id = Auth::user()->project_id ??'';
        $cash->opening_balance = $request->opening_balance;
        $cash->amount = $request->opening_balance;
        $cash->save();
        return redirect(route('cash'))->with('message', 'Cash Add successfully done.');
    }
    public function cashEdit(Cash $cash)
    {
        return view('cash.add', compact('cash'));
    }

    public function cashEditPost(Cash $cash , Request $request)
    {
        $this->validate($request, [
            'opening_balance' => 'required'
        ]);
        $data = $request->all();
        $cash = Cash::find($cash->id);
        if ($cash) {
            $cash->project_id = Auth::user()->project_id ??'';
            $old_amount = $request->opening_balance - $cash->opening_balance;
            $cash->opening_balance = $request->opening_balance;
            $cash->amount = $cash->amount + $old_amount;
            $cash->save();
        } else {
            $data['amount'] = $request->opening_balance;
            Cash::create($data);
        }
        return redirect(route('cash'))->with('message', 'Cash Edit successfully done.');
    }

    public function getProductUnit(Request $request)
    {

        $products = PurchaseProduct::with('unit')
            ->where('id', $request->productId)->first();
        // dd($products);
        $unit = $products->unit->name;
        // dd($unit);
        return response()->json($unit);
    }

    public function getRequisitionQuantity(Request $request)
    {

        $purchaseQuantity = ProductPurchaseOrder::where('project_id',Auth::user()->project_id)
            ->where('segment_id', $request->segmentId)
            ->where('product_id', $request->productId)
            ->sum('quantity');
        $requisitionIds = Requisition::where('project_id', Auth::user()->project_id)
            ->where('product_segment_id', $request->segmentId)->pluck('id');

        $requProductQuantity = ProductRequisition::whereIn('requisition_id', $requisitionIds)
                    ->where('purchase_product_id',$request->productId)
                    ->sum('quantity');

        $products = $requProductQuantity-$purchaseQuantity;

        return response()->json($products);
    }

    public function getInventoryProduct(Request $request)
    {

        $products = PurchaseInventory::with('product')
            ->where('segment_id', $request->segmentId)->get()->toArray();
        return response()->json($products);
    }
    public function getStakeholder(Request $request) {
        $products = ProjectWiseStakeholder::with('stakeholder')->where('project_id', $request->projectId)->get();
        return response()->json($products);
    }

    public function getProjectWiseSegment(Request $request) {
        $segment = ProductSegment::where('project_id', $request->projectId)->get();
        return response()->json($segment);
    }

    public function getPurchaseOrder(Request $request)
    {

        if ($request->orderId) {
            $order = PurchaseOrder::with('supplier')->find($request->orderId);
            $products = ProductPurchaseOrder::with('product')
                ->where('purchase_order_id', $order->id)->get();


            return response()->json(['success' => true, 'order' => $order, 'products' => $products]);
            //  'redirect_url' => route('purchase_receipt.payment_details', ['payment' => $payment->id])]

        }

        // dd($products);
    }

    public function getProductPurchaseOrder(Request $request)
    {

        $productPurchaseOrder = ProductPurchaseOrder::find($request->productPurchaseOrderId);

        return response()->json($productPurchaseOrder);
    }

    public function getProductFromRq(Request $request)
    {
        // dd($request->all());

        $requisitionIds = Requisition::where('project_id', $request->projectId)
            ->where('product_segment_id', $request->segmentId)->pluck('id');
        $productIds = ProductRequisition::whereIn('requisition_id', $requisitionIds)->pluck('purchase_product_id');
        $products = PurchaseProduct::whereIn('id', $productIds)->get();
        // dd($products);
        return response()->json($products);
    }
}
