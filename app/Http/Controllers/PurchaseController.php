<?php

namespace App\Http\Controllers;
use App\Models\Costing;
use App\Models\PurchaseProductProductCosting;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Cash;
use App\Models\MobileBanking;
use App\Models\ProductPurchaseOrder;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\PurchaseInventory;
use App\Models\PurchaseInventoryLog;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderReceive;
use App\Models\PurchasePayment;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductUtilize;
use App\Models\Supplier;
use App\Models\TransactionLog;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use SakibRahaman\DecimalToWords\DecimalToWords;
use Yajra\DataTables\DataTables;
use function Sodium\increment;

class PurchaseController extends Controller
{


    public function purchaseOrder()
    {
        $suppliers = Supplier::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
        $warehouses = Warehouse::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();

        $banks = Bank::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
        //$projects = Project::where('id',Auth::user()->project_id)->where('status', 1)->get();
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status', 1)->get();
        $products = PurchaseProduct::where('project_id',Auth::user()->project_id)->where('status', 1)->get();

        return view('purchase.purchase_order.create', compact(
            'suppliers',
            'warehouses',
            'banks',
            'segments',
            'products'
        ));
    }

    public function purchaseOrderPost(Request $request)
    {
        $rules = [
            'supplier' => 'required',
            //'project' => 'required',
            'segment' => 'required',
            'date' => 'required|date',
            'note' => 'nullable',
            // 'requisition_id' => 'required',
            'product.*' => 'required',
            // 'available.*' => 'required|numeric|min:1',
            'quantity.*' => 'required|numeric|min:1',
            'unit_price.*' => 'required|numeric|min:1',
            'vat' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0|max:' . $request->total,
        ];

        if ($request->payment_type == '2') {
            $rules['bank'] = 'required';
            $rules['branch'] = 'required';
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        $request->validate($rules);

        foreach ($request->product as $key => $reqProduct) {
            $product = PurchaseProduct::findOrFail($reqProduct);
        
            $InitialQuantity = PurchaseProductProductCosting::where('purchase_product_id', $reqProduct)
            ->whereHas('costing', function($query) use ($request) {
                $query->where('costing_type_id', $request->segment);
            })
            ->first();
           
            
        
       
            
           
        
        
            if ( $InitialQuantity->quantity <= $request->quantity[$key] ) {
       
              return redirect()->back()
                    ->withInput()
                    ->with('message', 'limited quantity balance');

            }
    
        }

        //Supplier Payment balance check

//        if ($request->paid > 0) {
//            if ($request->payment_type == 1) {
//                $cash = Cash::first();
//
//                if ($request->paid > $cash->amount) {
//                    return redirect()->back()
//                        ->withInput()
//                        ->with('message', 'Insufficient balance');
//                }
//            } elseif ($request->payment_type == 3) {
//                $mobileBanking = MobileBanking::first();
//                if ($request->paid > $mobileBanking->amount) {
//                    return redirect()->back()
//                        ->withInput()
//                        ->with('message', 'Insufficient balance');
//                }
//            } else {
//                $bankAccount = BankAccount::find($request->account);
//                if ($request->paid > $bankAccount->balance) {
//                    return redirect()->back()->withInput()->with('message', 'Insufficient balance');
//                }
//            }
//        }

$order = new PurchaseOrder();

$order->supplier_id = $request->supplier;
$order->project_id = Auth::user()->project_id;
$order->segment_id = $request->segment;
$order->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
$order->note = $request->note;
$order->vat_percentage = $request->vat;
$order->vat = 0;
$order->discount_percentage = $request->discount;
$order->discount = 0;
$order->paid = $request->paid;
$order->total = 0;
$order->due = 0;
$order->user_id = Auth::id();
$order->save();
$order->order_no = 100000 + $order->id;
$order->save();

$subTotal = 0;
foreach ($request->product as $key => $reqProduct) {
    $product = PurchaseProduct::findOrFail($reqProduct);

    $productPurchaseOrder = new ProductPurchaseOrder();

    $productPurchaseOrder->purchase_order_id = $order->id;
    $productPurchaseOrder->name = $product->name;
    $productPurchaseOrder->product_id = $product->id;
    $productPurchaseOrder->project_id = Auth::user()->project_id;
    $productPurchaseOrder->segment_id = $request->segment;
    $productPurchaseOrder->quantity = $request->quantity[$key];
    $productPurchaseOrder->unit_price = $request->unit_price[$key];
    $productPurchaseOrder->total = $request->quantity[$key] * $request->unit_price[$key];
    $productPurchaseOrder->save();

    $InitialQuantity = PurchaseProductProductCosting::where('purchase_product_id', $reqProduct)
    ->whereHas('costing', function($query) use ($request) {
        $query->where('costing_type_id', $request->segment);
    })
    ->first();
    $InitialQuantityValue = $InitialQuantity->quantity;
    
    

    $remainingQuantity = PurchaseProductProductCosting::where('purchase_product_id', $reqProduct)
    ->whereHas('costing', function($query) use ($request) {
        $query->where('costing_type_id', $request->segment);
    })
    ->first();
    $remainingQuantityValue = $remainingQuantity->remaining_quantity;
   
  

    if ($remainingQuantityValue <= 0) {
        
      $getQuantity = $request->quantity[$key];
    //   dd($getQuantity,"1st");
       
      $remainingQuantity->remaining_quantity = $getQuantity;
       
    
        $remainingQuantity->save();
   
      
    }else{
        
        $getQuantity = $remainingQuantity->remaining_quantity += $request->quantity[$key];
        // dd($getQuantity,"2nd");
   
        $remainingQuantity->remaining_quantity = $getQuantity;
   

    $remainingQuantity->save();
    }

    $subTotal += $productPurchaseOrder->total;
}

// Update order total
// $order->total = $subTotal;
// $order->save();

// Additional logic if needed...

        $order->sub_total = $subTotal;
        $vat = ($subTotal * $request->vat) / 100;
        $discount = ($subTotal * $request->discount) / 100;
        $order->vat = $vat;
        $order->discount = $discount;
        $total = $subTotal + $vat - $discount;
        $order->total = $total;
        $due = $total - $request->paid;
        $order->due = $due;
        $order->save();

        // dd('Done');
        // Sales Payment
        if ($request->paid > 0) {
            if ($request->payment_type == 1 || $request->payment_type == 3) {
                $payment = new PurchasePayment();
                $payment->supplier_id = $request->supplier;
                $payment->project_id = Auth::user()->project_id;
                $payment->purchase_order_id = $order->id;
                $payment->transaction_method = $request->payment_type;
                $payment->received_type = 1;
                $payment->type = 1; //payment
                $payment->amount = $request->paid;
                $payment->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
                $payment->user_id = Auth::id();
                $payment->note = 'Payment for order no-' . $order->order_no;
                $payment->save();
                $payment->id_no=10000 + $payment->id;
                $payment->save();


                if ($request->payment_type == 1)
                    Cash::where('project_id',Auth::user()->project_id)->first()->decrement('amount', $request->paid);
                elseif ($request->payment_type == 3)
                    MobileBanking::first()->decrement('amount', $request->paid);

                $log = new TransactionLog();
                $log->project_id = Auth::user()->project_id;
                $log->supplier_id = $request->supplier;
                $log->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
                $log->particular = 'Paid to order no-' . $order->id;
                $log->transaction_type = 2;  //Expense
                $log->transaction_method = $request->payment_type;
                $log->account_head_type_id = 1;
                $log->account_head_sub_type_id = 1;
                $log->user_id = Auth::id();
                $log->amount = $request->paid;
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
                $payment->project_id = Auth::user()->project_id;
                $payment->supplier_id = $request->supplier;
                $payment->purchase_order_id = $order->id;
                $payment->transaction_method = $request->payment_type;
                $payment->received_type = 1;
                $payment->type = 1; //payment
                $payment->bank_id = $request->bank;
                $payment->branch_id = $request->branch;
                $payment->bank_account_id = $request->account;
                $payment->cheque_no = $request->cheque_no;
                $payment->cheque_image = $image;
                $payment->amount = $request->paid;
                $payment->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
                $payment->user_id = Auth::id();
                $payment->note = 'Payment for order no-' . $order->order_no;
                $payment->save();
                $payment->id_no=10000 + $payment->id;
                $payment->save();

                BankAccount::where('project_id',Auth::user()->project_id)->decrement('balance', $request->paid);

                $log = new TransactionLog();
                $log->project_id = Auth::user()->project_id;
                $log->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
                $log->particular = 'Paid to order no-' . $order->id;
                $log->transaction_type = 2;  //Expense
                $log->transaction_method = $request->payment_type;
                $log->account_head_type_id = 1;
                $log->account_head_sub_type_id = 1;
                $log->bank_id = $request->bank;
                $log->branch_id = $request->branch;
                $log->bank_account_id = $request->account;
                $log->cheque_no = $request->cheque_no;
                $log->cheque_image = $image;
                $log->user_id = Auth::id();
                $log->amount = $request->paid;
                $log->purchase_payment_id = $payment->id;
                $log->save();
            }
        }

        return redirect()->route('purchase_receipt.details', ['order' => $order->id]);
    }

    public function purchaseReceiptEdit(PurchaseOrder $order)
    {
        $suppliers = Supplier::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
        $warehouses = Warehouse::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();

        $banks = Bank::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
        $projects = Project::where('id',Auth::user()->project_id)->where('status', 1)->get();
        $products = PurchaseProduct::where('project_id',Auth::user()->project_id)->where('status', 1)->get();

        return view('purchase.purchase_order.edit', compact(
            'order','projects','products',
            'suppliers',
            'banks'
        ));
    }

    public function purchaseReceiptEditPost(PurchaseOrder $order, Request $request)
    {

        $total = $request->total;
        $due = $request->due_total;
        $refund = $request->refund;

        $rules = [
            'supplier' => 'required',
            'project' => 'required',
            'segment' => 'required',
            'date' => 'required|date',
            'product.*' => 'required',
            'quantity.*' => 'required|numeric|min:.1',
            'unit_price.*' => 'required|numeric|min:1',
            'vat' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0|max:' . $request->total,
        ];

        if ($request->payment_type == '2') {
            $rules['bank'] = 'required';
            $rules['branch'] = 'required';
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        $request->validate($rules);

        //Supplier Payment balance check

//        if ($request->paid > 0) {
//            if ($request->payment_type == 1) {
//                $cash = Cash::first();
//
//                if ($request->paid > $cash->amount) {
//                    return redirect()->back()
//                        ->withInput()
//                        ->with('message', 'Insufficient balance');
//                }
//            } elseif ($request->payment_type == 3) {
//                $mobileBanking = MobileBanking::first();
//                if ($request->paid > $mobileBanking->amount) {
//                    return redirect()->back()
//                        ->withInput()
//                        ->with('message', 'Insufficient balance');
//                }
//            } else {
//                $bankAccount = BankAccount::find($request->account);
//                if ($request->paid > $bankAccount->balance) {
//                    return redirect()->back()->withInput()->with('message', 'Insufficient balance');
//                }
//            }
//        }

        $previousProductsId = [];

        foreach ($order->products as $product) {
            $previousProductsId[] = $product->id;
        }

        if ($order->lc_no != $request->lc_no) {
            PurchaseInventory::where('lc_no', $order->lc_no)->update([
                'lc_no' => $request->lc_no
            ]);
            PurchaseInventoryLog::where('type', 1)
                ->where('lc_no', $order->lc_no)
                ->update([
                    'lc_no' => $request->lc_no
                ]);

            $order->lc_no = $request->lc_no;
            $order->save();
        }


        $getOldWarehouse = PurchaseInventory::where('lc_no', $request->lc_no)->first();

        if ($order->hide_show != ($request->hide_show ? 1 : 2)) {
            PurchaseInventory::where('lc_no', $request->lc_no)->update([
                'hide_show' => $request->hide_show ? 1 : 2
            ]);
        }

        if ($request->warehouse != $getOldWarehouse->warehouse_id) {

            PurchaseInventory::where('lc_no', $request->lc_no)->update([
                'warehouse_id' => $request->warehouse
            ]);
            PurchaseInventoryLog::where('type', 1)
                ->where('lc_no', $request->lc_no)
                ->update([
                    'warehouse_id' => $request->warehouse
                ]);
        }


        $counter = 0;
        $subTotal = 0;
        if ($request->product) {
            foreach ($request->product as $reqProduct) {

                if (in_array($reqProduct, $previousProductsId)) {

                    // Old Item
                    $product = Product::find($request->product[$counter]);

                    $purchaseProduct = DB::table('product_purchase_order')
                        ->where('purchase_order_id', $order->id)
                        ->where('product_id', $reqProduct)
                        ->where('brand_id', $request->brand[$counter])
                        ->first();

                    DB::table('product_purchase_order')
                        ->where('purchase_order_id', $order->id)
                        ->where('product_id', $reqProduct)
                        ->where('brand_id', $request->brand[$counter])
                        ->update([
                            'product_id' => $request->product[$counter],
                            'category_id' => $request->category[$counter],
                            'brand_id' => $request->brand[$counter],
                            'name' => $product->name,
                            'quantity' => $request->quantity[$counter],
                            'unit_price' => $request->unit_price[$counter],
                            'selling_price' => $request->selling_price[$counter],
                            'total' => $request->quantity[$counter] * $request->unit_price[$counter],
                        ]);
                    $subTotal += $request->quantity[$counter] * $request->unit_price[$counter];

                    // Inventory
                    $checkInventory = PurchaseInventory::where('warehouse_id', $request->warehouse)
                        ->where('lc_no', $request->lc_no)
                        ->where('brand_id', $request->brand[$counter])
                        ->where('product_id', $product->id)->first();

                    $totalInventory = $checkInventory->quantity * $checkInventory->avg_unit_price;
                    $totalQty = $request->quantity[$counter] + $checkInventory->quantity;
                    $totalInventoryNPurchase = $totalInventory + $total;
                    $avgPrice = $totalInventoryNPurchase / $totalQty;

                    $inventory = PurchaseInventory::where('warehouse_id', $request->warehouse)
                        ->where('lc_no', $request->lc_no)
                        ->where('brand_id', $request->brand[$counter])
                        ->where('product_id', $reqProduct)
                        ->first();

                    $inventory->lc_no = $request->lc_no;
                    $inventory->product_id = $product->id;
                    $inventory->category_id = $request->category[$counter];
                    $inventory->brand_id = $request->brand[$counter];
                    $inventory->warehouse_id = $request->warehouse;
                    $inventory->quantity = $request->quantity[$counter];
                    $inventory->unit_price = $request->unit_price[$counter];
                    $inventory->selling_price = $request->selling_price[$counter];
                    $inventory->avg_unit_price = $avgPrice;
                    $inventory->save();

                    if ($request->quantity[$counter] != $purchaseProduct->quantity) {

                        $inventoryLog = new PurchaseInventoryLog();
                        $inventoryLog->lc_no = $request->lc_no;
                        $inventoryLog->product_id = $product->id;
                        $inventoryLog->category_id = $request->category[$counter];
                        $inventoryLog->brand_id = $request->brand[$counter];

                        if ($request->quantity[$counter] > $purchaseProduct->quantity) {
                            $inventoryLog->type = 3;
                            $inventoryLog->quantity = $request->quantity[$counter] - $purchaseProduct->quantity;
                        } else {
                            $inventoryLog->type = 4;
                            $inventoryLog->quantity = $purchaseProduct->quantity - $request->quantity[$counter];
                        }

                        $inventoryLog->date = date('Y-m-d');
                        $inventoryLog->warehouse_id = $request->warehouse;
                        $inventoryLog->unit_price = $request->unit_price[$counter];
                        $inventoryLog->supplier_id = $request->supplier;
                        $inventoryLog->purchase_order_id = $order->id;
                        $inventoryLog->save();
                    }

                    if (($key = array_search($reqProduct, $previousProductsId)) !== false) {
                        unset($previousProductsId[$key]);
                    }
                } else {

                    // New Item
                    $product = Product::find($request->product[$counter]);

                    $order->products()->attach($reqProduct, [
                        'name' => $product->name,
                        'category_id' => $product->category_id,
                        'brand_id' => $request->brand[$counter],
                        'quantity' => $request->quantity[$counter],
                        'unit_price' => $request->unit_price[$counter],
                        'selling_price' => $request->selling_price[$counter],
                        'total' => $request->quantity[$counter] * $request->unit_price[$counter],
                    ]);

                    $checkInventory = PurchaseInventory::where('warehouse_id', $request->warehouse)
                        ->where('lc_no', $request->lc_no)
                        ->where('brand_id', $request->brand[$counter])
                        ->where('product_id', $product->id)
                        ->first();

                    if ($checkInventory) {
                        $totalInventory = $checkInventory->quantity * $checkInventory->avg_unit_price;
                        $totalQty = $request->quantity[$counter] + $checkInventory->quantity;
                        $totalInventoryNPurchase = $totalInventory + $total;
                        $avgPrice = $totalInventoryNPurchase / $totalQty;

                        $checkInventory->increment('quantity', $request->quantity[$counter]);
                        $checkInventory->avg_unit_price = $avgPrice;
                        $checkInventory->unit_price = $request->unit_price[$counter];
                        $checkInventory->selling_price = $request->selling_price[$counter];
                        $checkInventory->save();
                    } else {
                        // Inventory
                        $inventory = new PurchaseInventory();
                        $inventory->category_id = $product->category_id;
                        $inventory->product_id = $product->id;
                        $inventory->brand_id = $request->brand[$counter];
                        $inventory->lc_no = $request->lc_no;
                        $inventory->quantity = $request->quantity[$counter];
                        $inventory->unit_price = $request->unit_price[$counter];
                        $inventory->selling_price = $request->selling_price[$counter];
                        $inventory->avg_unit_price = $request->unit_price[$counter];
                        $inventory->warehouse_id = $request->warehouse;
                        $inventory->save();
                    }
                    // Inventory Log
                    $inventoryLog = new PurchaseInventoryLog();
                    $inventoryLog->category_id = $product->category_id;
                    $inventory->brand_id = $request->brand[$counter];
                    $inventory->lc_no = $request->lc_no;
                    $inventoryLog->product_id = $product->id;
                    $inventoryLog->type = 1;
                    $inventoryLog->date = $request->date;
                    $inventoryLog->warehouse_id = $request->warehouse;
                    $inventoryLog->quantity = $request->quantity[$counter];
                    $inventoryLog->unit_price = $request->unit_price[$counter];
                    $inventoryLog->supplier_id = $request->supplier;
                    $inventoryLog->purchase_order_id = $order->id;
                    $inventoryLog->save();

                    $subTotal += $request->quantity[$counter] * $request->unit_price[$counter];
                }

                $counter++;
            }
        }
        // Delete items
        $counter = 0;
        foreach ($previousProductsId as $reqProduct) {

            $purchaseProduct = DB::table('product_purchase_order')
                ->where('purchase_order_id', $order->id)
                ->where('product_id', $reqProduct)
                ->first();

            $inventory = PurchaseInventory::where('product_id', $reqProduct)
                ->where('warehouse_id', $request->warehouse)
                ->where('lc_no', $request->lc_no)
                ->where('brand_id', $purchaseProduct->brand_id)
                ->where('product_id', $purchaseProduct->product_id)
                ->first();

            $inventoryLog = new PurchaseInventoryLog();
            $inventoryLog->lc_no = $request->lc_no;
            $inventoryLog->product_id = $purchaseProduct->product_id;
            $inventoryLog->category_id = $purchaseProduct->category_id;
            $inventoryLog->brand_id = $purchaseProduct->brand_id;
            $inventoryLog->type = 4;
            $inventoryLog->quantity = $purchaseProduct->quantity;
            $inventoryLog->date = date('Y-m-d');
            $inventoryLog->warehouse_id = $request->warehouse;
            $inventoryLog->unit_price = $purchaseProduct->unit_price;
            $inventoryLog->supplier_id = $request->supplier;
            $inventoryLog->purchase_order_id = $order->id;
            $inventoryLog->save();

            $inventory->decrement('quantity', $request->quantity[$counter] ?? 0);

            DB::table('product_purchase_order')
                ->where('purchase_order_id', $order->id)
                ->where('product_id', $reqProduct)->delete();

            $counter++;
        }

        // Update Order
        $order->hide_show = $request->hide_show ? 1 : 2;
        $order->supplier_id = $request->supplier;
        $order->warehouse_id = $request->warehouse;
        $order->date = $request->date;
        $order->sub_total = $subTotal;
        $order->vat_percentage = $request->vat;
        $vat = ($subTotal * $request->vat) / 100;
        $order->discount_percentage = $request->discount;
        $discount = ($subTotal * $request->discount) / 100;
        $order->discount = $discount;
        $order->vat = $vat;
        $total = $subTotal + $vat - $discount;
        $order->total = $total;
        $order->due = $total - $order->paid;
        $order->refund = $refund;
        $order->save();

        // Sales Payment
        if ($request->paid > 0) {

            $order->due = $total - ($order->paid + $request->paid);
            $order->save();

            if ($request->payment_type == 1 || $request->payment_type == 3) {
                $payment = new PurchasePayment();
                $payment->purchase_order_id = $order->id;
                $payment->transaction_method = $request->payment_type;
                $payment->received_type = 1;
                $payment->amount = $request->paid;
                $payment->date = $request->date;
                $payment->save();

                if ($request->payment_type == 1)
                    Cash::first()->increment('amount', $request->paid);
                elseif ($request->payment_type == 3)
                    MobileBanking::first()->increment('amount', $request->paid);

                $log = new TransactionLog();
                $log->date = $request->date;
                $log->particular = 'Paid to LC-' . $request->lc_no;
                $log->transaction_type = 2;
                $log->transaction_method = $request->payment_type;
                $log->account_head_type_id = 1;
                $log->account_head_sub_type_id = 1;
                $log->amount = $request->paid;
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
                $payment->transaction_method = 2;
                $payment->received_type = 1;
                $payment->bank_id = $request->bank;
                $payment->branch_id = $request->branch;
                $payment->bank_account_id = $request->account;
                $payment->cheque_no = $request->cheque_no;
                $payment->cheque_image = $image;
                $payment->amount = $request->paid;
                $payment->date = $request->date;
                $payment->save();

                BankAccount::find($request->account)->increment('balance', $request->paid);

                $log = new TransactionLog();
                $log->date = $request->date;
                $log->particular = 'Paid to LC-' . $request->lc_no;
                $log->transaction_type = 2;
                $log->transaction_method = 2;
                $log->account_head_type_id = 1;
                $log->account_head_sub_type_id = 1;
                $log->bank_id = $request->bank;
                $log->branch_id = $request->branch;
                $log->bank_account_id = $request->account;
                $log->cheque_no = $request->cheque_no;
                $log->cheque_image = $image;
                $log->amount = $request->paid;
                $log->purchase_payment_id = $payment->id;
                $log->save();
            }
        }


        return redirect()->route('purchase_receipt.details', ['order' => $order->id]);
    }

    public function utilizeAllProject(){

        return view('purchase.utilize.projects');
    }

    public function utilizeProjectDatatable(){
        $query = Project::where('id',Auth::user()->project_id);

        return \Yajra\DataTables\Facades\DataTables::eloquent($query)
            ->addColumn('action', function (Project $project) {
                return '<a class="btn btn-info btn-sm" href="' . route('purchase_product.utilize.all', ['project' => $project->id]) . '">View Utilize</a>';
            })
            ->editColumn('status', function (Project $project) {
                if ($project->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }


    public function utilizeIndex(Project $project)
    {


        return view('purchase.utilize.all',compact('project'));
    }

    public function utilizeAdd(Project $project)
    {
        $products = PurchaseProduct::where('project_id',Auth::user()->project_id)->where('status', 1)
            ->orderBy('name')->get();

        return view('purchase.utilize.add', compact('products', 'project'));
    }

    public function utilizeAddPost(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'project' => 'required',
            'segment' => 'required',
            'product' => 'required',
            'quantity' => 'required|numeric|min:0.01',
            'date' => 'date',
            'note' => 'nullable|string|max:255',
        ]);

        //dd($request->all());
        //        if ($validator->fails()) {
        //            return redirect()->back()
        //                ->withErrors($validator)
        //                ->withInput();
        //        }

        $validator->after(function ($validator) use ($request) {
            $inventory = PurchaseInventory::where('project_id', $request->project)
                ->where('segment_id', $request->segment)
                ->where('product_id', $request->product)
                ->first();
            if ($inventory) {
                if ($inventory->quantity < $request->quantity) {
                    $validator->errors()->add('quantity', 'Insufficient stock.');
                }
            } else {
                $validator->errors()->add('quantity', 'Insufficient stock.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $inventory = PurchaseInventory::where('project_id', $request->project)
            ->where('segment_id', $request->segment)
            ->where('product_id', $request->product)
            ->first();

        $inventoryLog = new PurchaseInventoryLog();
        $inventoryLog->product_id = $request->product;
        $inventoryLog->purchase_inventory_id = $inventory->id;
        $inventoryLog->project_id = $request->project;
        $inventoryLog->segment_id = $request->segment;
        $inventoryLog->type = 2; //out
        $inventoryLog->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $inventoryLog->unit_price = $inventory->unit_price;
        $inventoryLog->quantity = $request->quantity;
        $inventoryLog->total = $request->quantity * $inventory->unit_price;
        $inventoryLog->note = 'Purchase Product Utilize';
        $inventoryLog->user_id = Auth::id();
        $inventoryLog->save();

        $utilize = new PurchaseProductUtilize();
        $utilize->product_id = $request->product;
        $utilize->purchase_inventory_id    = $inventory->id;
        $utilize->purchase_inventory_log_id    = $inventoryLog->id;
        $utilize->project_id = $request->project;
        $utilize->product_segment_id = $request->segment;
        $utilize->quantity = $request->quantity;
        $utilize->unit_price = $inventory->unit_price;
        $utilize->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $utilize->note = $request->note;
        $utilize->user_id = Auth::id();
        $utilize->save();

        PurchaseInventory::where('project_id', $request->project)
            ->where('segment_id', $request->segment)
            ->where('product_id', $request->product)
            ->decrement('quantity', $request->quantity);



        $log = new TransactionLog();
        $log->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $log->particular = 'Purchase Product Utilize';
        $log->project_id = $request->project;
        $log->product_segment_id = $request->segment;
        $log->transaction_type = 4;
        $log->account_head_type_id = 6;
        $log->account_head_sub_type_id = 6;
        $log->amount = $request->quantity * $inventory->unit_price;
        $log->note = $request->note;
        $log->user_id = Auth::id();
        $log->purchase_product_utilize_id = $utilize->id;
        $log->save();

        return redirect()->route('purchase_product.utilize.all',['project'=>$project->id])->with('message', 'Utilize add successfully.');
    }




    public function utilizeDatatable(Request $request)
    {
        $query = PurchaseProductUtilize::where('project_id',$request->project)->with('product', 'purchaseOrder', 'project');


        return DataTables::eloquent($query)
            ->addColumn('product', function (PurchaseProductUtilize $utilize) {
                return $utilize->product->name;
            })
            ->addColumn('project', function (PurchaseProductUtilize $utilize) {
                return $utilize->project->name;
            })
            ->addColumn('segment', function (PurchaseProductUtilize $utilize) {
                return $utilize->segment->name;
            })
            ->editColumn('quantity', function (PurchaseProductUtilize $utilize) {
                return number_format($utilize->quantity, 2) . ' ' . $utilize->product->unit->name;
            })
            ->editColumn('date', function (PurchaseProductUtilize $utilize) {
                return $utilize->date->format('j F, Y');
            })
            ->editColumn('unit_price', function (PurchaseProductUtilize $utilize) {
                return ' ' . number_format($utilize->unit_price, 2);
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order)->orderBy('created_at', 'desc');
            })
            ->toJson();
    }


    public function purchaseProjects(){
      //  $projects = Project::where('status', 1)->get();

        return view('purchase.receipt.all_project');
    }


    public function purchaseReceipt()
    {
        return view('purchase.receipt.all');
    }

    public function purchaseReceiptDetails(PurchaseOrder $order)
    {
        return view('purchase.receipt.details', compact('order'));
    }

    public function purchaseReceiveDetails(PurchaseOrder $order){

        $receives= PurchaseOrderReceive::where('purchase_order_id',$order->id)->get();
        return view('purchase.receipt.receive_details',compact('receives','order'));
    }

    public function purchaseReceiptPrint(PurchaseOrder $order)
    {
        return view('admin.purchase.receipt.print', compact('order'));
    }

    public function barCode(PurchaseOrder $order)
    {
        return view('admin.purchase.receipt.qr_code', compact('order'));
    }

    public function barCodePrint(PurchaseOrder $order)
    {

        return view('admin.purchase.receipt.qr_code_print', compact('order'));
    }


    public function allBarCodePrint(PurchaseOrder $order)
    {

        return view('admin.purchase.receipt.all_qr_code_print', compact('order'));
    }


    public function barSingleCodePrint($order)
    {
        $product = ProductPurchaseOrder::with('product')->where('id', $order)->first();
        return view('admin.purchase.receipt.qr_code_print', compact('product'));
    }

    public function supplierPayment()
    {
        $suppliers = Supplier::where('project_id',Auth::user()->project_id)->get();
        $bankAccounts = BankAccount::where('project_id',Auth::user()->project_id)->where('status', 1)->get();
        return view('purchase.supplier_payment.all', compact('suppliers', 'bankAccounts'));
    }

    public function supplierPaymentDetails(Supplier $supplier) {
        return view('purchase.supplier_payment.supplier_payment_details', compact('supplier'));
    }

    public function supplierPaymentGetOrders(Request $request) {
        $orders = PurchaseOrder::with('segment')->where('supplier_id', $request->supplierId)
            ->where('due', '>', 0)
            ->orderBy('order_no')
            ->get()->toArray();

        return response()->json($orders);
    }

    public function supplierPaymentGetRefundOrders(Request $request)
    {
        $orders = PurchaseOrder::where('supplier_id', $request->supplierId)
            ->where('refund', '>', 0)
            ->orderBy('order_no')
            ->get()->toArray();

        return response()->json($orders);
    }

    public function supplierPaymentOrderDetails(Request $request)
    {
        $order = PurchaseOrder::where('id', $request->orderId)
            ->first()->toArray();

        return response()->json($order);
    }

    public function makePayment(Request $request)
    {
        $rules = [
            'order' => 'required',
            'segment' => 'required',
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
            $payment->segment_id = $request->segment;
            $payment->supplier_id = $order->supplier_id;
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
                Cash::first()->decrement('amount', $request->amount);
            else
                MobileBanking::first()->decrement('amount', $request->amount);

            $log = new TransactionLog();
            $log->date = date("Y-m-d", strtotime($request->date));
            $log->supplier_id = $order->supplier_id;
            $log->project_id = $order->project_id;
            $log->product_segment_id = $request->segment;
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

            BankAccount::find($request->account)->decrement('balance', $request->amount);

            $log = new TransactionLog();
            $log->date = date("Y-m-d", strtotime($request->date));
            $log->supplier_id = $order->supplier_id;
            $log->project_id = $order->project_id;
            $log->product_segment_id = $request->segment;
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


    public function purchaseProductReceive(Request $request)
    {
        //  dd($request->all());
        $rules = [
            'order_id' => 'required',
            'product_purchase_order_id' => 'required',
            'order_no' => 'required',
            'product' => 'required',
            'challan_no' => 'required',
            'total_quantity' => 'required|numeric',
            'complete_quantity' => 'required|numeric',
            'receive_quantity' => 'required|numeric|min:1|max:' . ($request->total_quantity - $request->complete_quantity),
            'date' => 'required',
            'note' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $order = ProductPurchaseOrder::find($request->product_purchase_order_id);

        if ($request->receive_quantity > ($order->quantity - $order->receive_quantity)) {
            return response()->json(['success' => false, 'message' => 'Quantity is greater.']);
        }


        $order->increment('receive_quantity',$request->receive_quantity);
        $order->save();

        $store = new PurchaseOrderReceive();
        $store->purchase_order_id = $request->order_id;
        $store->product_purchase_order_id = $order->id;
        $store->purchase_product_id = $order->product_id;
        $store->challan_no = $request->challan_no;
        $store->user_id = Auth::id();
        $store->quantity = $request->receive_quantity;
        $store->date = $request->date;
        $store->note = $request->note;
        $store->save();

          // Inventory
            $inventoryCheck = PurchaseInventory::where('product_id', $order->product_id)
                ->where('project_id', $order->purchaseOrder->project_id)
                ->where('segment_id', $order->purchaseOrder->segment_id)
                ->first();

         //   dd($inventoryCheck);
            if ($inventoryCheck) {

                $inventoryCheck->increment('quantity', $request->receive_quantity);
                $inventoryCheck->unit_price = $order->unit_price;
                $inventoryCheck->avg_unit_price = $order->unit_price;
                $inventoryCheck->save();
                $inventoryCheck->total = $inventoryCheck->unit_price * $inventoryCheck->quantity;
                $inventoryCheck->save();

            } else {
                $inventory = new PurchaseInventory();
                $inventory->product_id = $order->product_id;
                $inventory->project_id = $order->purchaseOrder->project_id;
                $inventory->segment_id = $order->purchaseOrder->segment_id;
                $inventory->quantity = $request->receive_quantity;
                $inventory->unit_price = $order->unit_price;
                $inventory->avg_unit_price = $order->unit_price;
                $inventory->save();
                $inventory->total = $inventory->quantity * $inventory->unit_price;
                $inventory->save();
            }

            // Inventory Log
            $inventoryLog = new PurchaseInventoryLog();
            $inventoryLog->product_id = $order->product_id;
            $inventoryLog->project_id = $order->purchaseOrder->project_id;
            $inventoryLog->segment_id = $order->purchaseOrder->segment_id;
            $inventoryLog->supplier_id = $order->purchaseOrder->supplier_id;

            $inventoryLog->purchase_order_id = $order->purchaseOrder->id;
            $inventoryLog->type = 1;
            $inventoryLog->date = $request->date;
            $inventoryLog->quantity = $request->receive_quantity;
            $inventoryLog->unit_price = $order->unit_price;
            $inventoryLog->user_id = Auth::id();
            $inventoryLog->note = 'Purchase product';
            $inventoryLog->total = $request->receive_quantity * $order->unit_price;
            $inventoryLog->save();


        return response()->json(['success' => true, 'message' => 'Successfully Received']);
    }

    public function purchasePaymentDetails(PurchasePayment $payment) {
        $payment->amount_in_word = DecimalToWords::convert(
            $payment->amount,
            'Taka',
            'Poisa'
        );
        return view('purchase.receipt.payment_details', compact('payment'));
    }

    public function purchasePaymentEdit(PurchasePayment $payment){
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->orderBy('name')->get();
        $bankAccounts = BankAccount::where('project_id',Auth::user()->project_id)->get();
        return view('purchase.supplier_payment.supplier_payment_edit', compact('segments','bankAccounts','payment'));
    }

    public function purchasePaymentEditPost(PurchasePayment $payment, Request $request) {
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
            $bankAccount->increment('balance', $payment->amount);
        } elseif ($payment->transaction_method == 1) {
            Cash::where('project_id',Auth::user()->project_id)
                ->increment('amount', $payment->amount);
        }
        TransactionLog::where('purchase_payment_id',$payment->id)->delete();
        $payment->delete();

        $purchasePayment = new PurchasePayment();
        $purchasePayment->purchase_order_id = $payment->purchase_order_id;
        $purchasePayment->supplier_id = $payment->supplier_id;
        $purchasePayment->project_id = Auth::user()->project_id;
        $purchasePayment->segment_id = $request->segment;
        $purchasePayment->received_type = 1; //1=nogod, 2=due
        $purchasePayment->type = 1; //1=payment
        $purchasePayment->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $purchasePayment->bank_id = $account->bank_id;
            $purchasePayment->branch_id = $account->branch_id;
            $purchasePayment->bank_account_id = $account->id;
            $purchasePayment->cheque_no = $request->cheque_no;
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
            $purchasePayment->cheque_image = $image;
        }
        $purchasePayment->amount = $request->amount; //Total
        $purchasePayment->date = $request->date;
        $purchasePayment->note = $request->note;
        $purchasePayment->user_id = Auth::id();
        $purchasePayment->save();
        $purchasePayment->id_no = $payment->id_no;
        $purchasePayment->save();

        $log = new TransactionLog();
        $log->particular = 'Paid to ' . $payment->supplier->name . ' for Purchase no. ' . $payment->id_no;
        $log->date = $request->date;
        $log->purchase_payment_id = $purchasePayment->id;
        $log->supplier_id = $payment->supplier_id;
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
            $bankAccount->decrement('balance', $request->amount);
        } elseif ($request->payment_type == 1) {
            Cash::where('project_id',Auth::user()->project_id)->decrement('amount', $request->amount);
        }

//        return redirect()->route('purchase_receipt.payment_details',['payment' => $payment->id])
//            ->with('message', 'Supplier Payment Edit has been completed.');

        return redirect()->route('supplier_payment.all');
    }

    public function purchasePaymentPrint(PurchasePayment $payment) {
        $payment->amount_in_word = DecimalToWords::convert(
            $payment->amount,
            'Taka',
            'Poisa'
        );
        return view('purchase.receipt.payment_print', compact('payment'));
    }

    public function purchaseInventory(Project $project)
    {
        $inventories = PurchaseInventory::where('project_id',$project->id)->get();

        return view('purchase.inventory.all', compact('inventories','project'));
    }

    public function purchaseInventoryAllProject()
    {
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();

        return view('purchase.inventory.all_project', compact('projects'));
    }



    public function purchaseInventoryPrint()
    {
        $inventories = PurchaseInventory::where('project_id',Auth::user()->project_id)->get();

        return view('purchase.inventory.print', compact('inventories'));
    }

    public function purchaseInventoryDetails(PurchaseProduct $product, Project $project, ProductSegment $segment)
    {
        $logs = PurchaseInventoryLog::where('product_id', $product->id)
            ->where('project_id', $project->id)
            ->where('segment_id', $segment->id)
            ->get();
        //dd($logs);
        return view('purchase.inventory.details', compact('product', 'project', 'segment', 'logs'));
    }

    public function inventoryViewDatatable()
    {
        $query = Project::where('id',Auth::user()->project_id);

        return \Yajra\DataTables\Facades\DataTables::eloquent($query)
            ->addColumn('action', function (Project $project) {
                return '<a class="btn btn-info btn-sm" href="' . route('purchase_inventory.all', ['project' => $project->id]) . '">View Inventory</a>';
            })
            ->editColumn('status', function (Project $project) {
                if ($project->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }


    public function checkDeleteStatus(Request $request)
    {
        $inventory = PurchaseInventory::where('serial_no', $request->serial)->first();

        if ($inventory) {
            if ($inventory->quantity > 0) {
                return response()->json(['success' => true, 'message' => 'This product not sold.']);
            } else {
                return response()->json(['success' => false, 'message' => 'This product already sold.']);
            }
        }

        return response()->json(['success' => true, 'message' => 'Serial not found.']);
    }

    public function purchaseProductJson(Request $request)
    {
        if (!$request->searchTerm) {
            $products = PurchaseProduct::where('status', 1)->orderBy('name')->limit(10)->get();
        } else {
            $products = PurchaseProduct::where('status', 1)->where('name', 'like', '%' . $request->searchTerm . '%')->orderBy('name')->limit(10)->get();
        }

        $data = array();

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'text' => $product->name
            ];
        }

        echo json_encode($data);
    }


//    public function receiptProjectsDatatable(){
//        $estimateProjects = Project::where('id',Auth::user()->project_id)->where('status', 1)->get();
//    }


    public function purchaseReceiptDatatable()
    {
        $query = PurchaseOrder::where('project_id', Auth::user()->project_id)->with('supplier');
        //dd($query);

        return \Yajra\DataTables\Facades\DataTables::eloquent($query)
            ->addColumn('supplier', function (PurchaseOrder $order) {
                return $order->supplier->name??'';
            })
            ->addColumn('project', function (PurchaseOrder $order) {
                return $order->project->name??'';
            })
            ->addColumn('segment', function (PurchaseOrder $order) {
                return $order->segment->name??'';
            })
            ->addColumn('action', function (PurchaseOrder $order) {

                if($order->products->sum('receive_quantity')>=$order->products->sum('quantity')){
                    $btn = '<a href="' . route('purchase_receipt.details', ['order' => $order->id]) . '" class="btn btn-primary btn-sm mb-1"><i class="fa fa-eye"></i></a> ';
                   // $btn .= '<a href="' . route('purchase_receipt.edit', ['order' => $order->id]) . '" class="btn btn-primary btn-sm mb-1"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="' . route('purchase_receive.details', ['order' => $order->id]) . '" class="btn btn-primary btn-sm mb-1">Details</a> ';
                    return $btn;
                }else{
                    $btn = '<a href="' . route('purchase_receipt.details', ['order' => $order->id]) . '" class="btn btn-primary btn-sm mb-1"><i class="fa fa-eye"></i></a> ';
                    $btn .= ' <button data-id="' . $order->id . '" class="btn btn-primary btn-sm btn-delivery">Receive</button> ';
                //    $btn .= '<a href="' . route('purchase_receipt.edit', ['order' => $order->id]) . '" class="btn btn-primary btn-sm mb-1"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="' . route('purchase_receive.details', ['order' => $order->id]) . '" class="btn btn-primary btn-sm mb-1">Details</a> ';
                    return $btn;
                }


            })

            //            ->filterColumn('products_code', function ($query, $keyword) {
            //                $order_products = PurchaseProduct::where('code','like', '%'.$keyword.'%')->pluck('id');
            //                $order_ids = PurchaseOrderPurchaseProduct::whereIn('purchase_product_id', $order_products)->distinct('purchase_order_id')->pluck('purchase_order_id');
            //                return $query->whereIn('id', $order_ids);
            //            })
            ->editColumn('date', function (PurchaseOrder $order) {
                return $order->date;
            })
            ->editColumn('total', function (PurchaseOrder $order) {
                return '৳' . number_format($order->total, 2);
            })
            ->editColumn('paid', function (PurchaseOrder $order) {
                return '৳' . number_format($order->paid, 2);
            })
            ->editColumn('due', function (PurchaseOrder $order) {
                return '৳' . number_format($order->due, 2);
            })
            ->editColumn('refund', function (PurchaseOrder $order) {
                return '৳' . number_format($order->refund, 2);
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function qrProduct()
    {
        return view('purchase.inventory.qr_product');
    }

    public function qrProductDatatable()
    {
        $query = PurchaseInventory::where('project_id',Auth::user()->project_id)->with('product', 'category', 'subcategory', 'subSubCategory', 'brand');

        return DataTables::eloquent($query)
            ->addColumn('product', function (PurchaseInventory $inventory) {
                return $inventory->product->name;
            })
            ->addColumn('category', function (PurchaseInventory $inventory) {
                return $inventory->category->name;
            })
            ->addColumn('subcategory', function (PurchaseInventory $inventory) {
                return $inventory->subcategory->name;
            })
            ->addColumn('subSubCategory', function (PurchaseInventory $inventory) {
                return $inventory->subSubCategory->name;
            })
            ->addColumn('brand', function (PurchaseInventory $inventory) {
                return $inventory->brand->name;
            })
            ->addColumn('attributes', function (PurchaseInventory $inventory) {
                return $inventory->color->name . '->' . $inventory->size->name;
            })
            ->addColumn('action', function (PurchaseInventory $inventory) {

                $purchaseProduct = DB::table('purchase_order_purchase_product')
                    ->where('serial_no', $inventory->serial_no)
                    ->first();

                return '<a target="_blank" href="' . route('purchase_receipt.qr_code_single_print', ['order' => $purchaseProduct->id]) . '" class="btn btn-primary btn-sm">BarCode <i class="fa fa-print"></i></a> <a href="' . route('purchase_receipt.edit', ['order' => $purchaseProduct->purchase_order_id]) . '" class="btn btn-primary btn-sm">Edit</a>';
            })
            ->editColumn('quantity', function (PurchaseInventory $inventory) {
                return number_format($inventory->quantity, 2);
            })
            ->editColumn('selling_price', function (PurchaseInventory $inventory) {
                return '৳ ' . number_format($inventory->selling_price, 2);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function purchaseInventoryDatatable()
    {
        $query = PurchaseInventory::where('project_id',Auth::user()->project_id)->with('product');


        return DataTables::eloquent($query)
            ->addColumn('product', function (PurchaseInventory $inventory) {
                return $inventory->product->name;
            })
            ->addColumn('project', function (PurchaseInventory $inventory) {
                return $inventory->project->name;
            })
            ->addColumn('segment', function (PurchaseInventory $inventory) {
                return $inventory->segment->name;
            })
            ->addColumn('action', function (PurchaseInventory $inventory) {
                return '';
            })

            ->editColumn('quantity', function (PurchaseInventory $inventory) {
                return number_format($inventory->quantity, 2);
            })
            ->editColumn('unit_price', function (PurchaseInventory $inventory) {
                return number_format($inventory->unit_price, 2);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function purchaseInventoryDetailsDatatable(Request $request)
    {

//        $logs = PurchaseInventoryLog::where('product_id', $product->id)
//            ->where('project_id', $project->id)
//            ->where('segment_id', $segment->id)
//            ->get();

        $query = PurchaseInventoryLog::where('product_id', request('product_id'))
            ->where('brand_id', request('brand_id'))
            ->with('product', 'supplier', 'purchaseOrder');


        return DataTables::eloquent($query)
            ->editColumn('date', function (PurchaseInventoryLog $log) {
                return $log->date->format('d-m-Y');
            })
            ->editColumn('type', function (PurchaseInventoryLog $log) {
                if ($log->type == 1)
                    return '<span class="label label-success">Purchase In</span>';
                elseif ($log->type == 2)
                    return '<span class="label label-danger">Sale Out</span>';
                elseif ($log->type == 3)
                    return '<span class="label label-success">Sale Return</span>';
                elseif ($log->type == 4)
                    return '<span class="label label-danger">Purchase Return</span>';
                elseif ($log->type == 5)
                    return '<span class="label label-danger">Transfer Out</span>';
                elseif ($log->type == 6)
                    return '<span class="label label-success">Transfer In</span>';
            })
            ->editColumn('quantity', function (PurchaseInventoryLog $log) {
                return number_format($log->quantity, 2);
            })
            ->editColumn('avg_unit_price', function (PurchaseInventoryLog $log) {
                return number_format($log->avg_unit_price, 2);
            })
            ->editColumn('selling_price', function (PurchaseInventoryLog $log) {
                return number_format($log->selling_price, 2);
            })
            ->editColumn('last_unit_price', function (PurchaseInventoryLog $log) {
                return number_format($log->last_unit_price, 2);
            })
            ->editColumn('total', function (PurchaseInventoryLog $log) {
                return number_format($log->total, 2);
            })
            ->editColumn('unit_price', function (PurchaseInventoryLog $log) {
                if ($log->unit_price)
                    return '৳' . number_format($log->unit_price, 2);
                else
                    return '';
            })
            ->editColumn('supplier', function (PurchaseInventoryLog $log) {
                if ($log->supplier)
                    return $log->supplier->name;
                else
                    return '';
            })
            ->editColumn('purchase_order', function (PurchaseInventoryLog $log) {
                if ($log->purchaseOrder)
                    return '<a href="' . route('purchase_receipt.details', ['order' => $log->purchaseOrder->id]) . '">' . $log->purchaseOrder->lc_no . '</a>';
                else
                    return '';
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['type', 'order', 'purchase_order'])
            ->filter(function ($query) {
                if (request()->has('date') && request('date') != '') {
                    $dates = explode(' - ', request('date'));
                    if (count($dates) == 2) {
                        $query->where('date', '>=', $dates[0]);
                        $query->where('date', '<=', $dates[1]);
                    }
                }

                if (request()->has('type') && request('type') != '') {
                    $query->where('type', request('type'));
                }
            })
            ->toJson();
    }
}
