<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::where('project_id',Auth::user()->project_id)->get();
        return view('purchase.supplier.all', compact('suppliers'));
    }

    public function add() {
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        return view('purchase.supplier.add',compact('projects'));
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

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->project_id = Auth::user()->project_id??'';
        $supplier->company_name = $request->company_name;
        $supplier->mobile = $request->mobile;
        $supplier->alternative_mobile = $request->alternative_mobile;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->status = $request->status;
        $supplier->save();

        return redirect()->route('supplier')->with('message', 'Supplier add successfully.');
    }

    public function edit(Supplier $supplier) {
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        return view('purchase.supplier.edit', compact('supplier','projects'));
    }

    public function editPost(Supplier $supplier, Request $request) {
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

        $supplier->name = $request->name;
        $supplier->project_id = Auth::user()->project_id??'';
        $supplier->company_name = $request->company_name;
        $supplier->mobile = $request->mobile;
        $supplier->alternative_mobile = $request->alternative_mobile;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->status = $request->status;
        $supplier->save();

        return redirect()->route('supplier')->with('message', 'Supplier edit successfully.');
    }

    public function supplierLedger(Request $request){

        $suppliers =Supplier::where('project_id',Auth::user()->project_id)->orderBy('name')->get();
        $appends = [];
        $query = PurchaseOrder::where('project_id',Auth::user()->project_id);

        if ($request->start && $request->end) {
            $query->whereBetween('date', [$request->start, $request->end]);
            $appends['date'] = $request->date;
        }

        if ($request->supplier && $request->supplier != '') {
            $query->where('supplier_id', $request->supplier);
            $appends['supplier'] = $request->supplier;
        }
        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
        $orders = $query->get();
        return view('report.supplier_ledger',compact('suppliers','orders','appends'));
    }


}
