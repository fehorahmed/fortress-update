<?php

namespace App\Http\Controllers;

use App\Imports\ImportPurchaseProduct;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\PurchaseProduct;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class PurchaseProductController extends Controller
{
    public function index() {
        $products = PurchaseProduct::where('project_id', Auth::user()->project_id)->with('unit')->get();
        return view('purchase.product.all', compact('products'));
    }

    public function add() {
        $units = Unit::where('project_id', Auth::user()->project_id)->orderBy('name')->get();
        $segments= ProductSegment::where('project_id', Auth::user()->project_id)->orderBy('name')->get();

        return view('purchase.product.add', compact('units','segments'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required',
            'estimate_cost' => 'nullable|max:20',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $product = new PurchaseProduct();
        $product->project_id = Auth::user()->project_id;
        $product->name = $request->name;
        $product->unit_id = $request->unit;
        $product->estimate_cost = $request->estimate_cost ?? null;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('purchase_product')->with('message', 'Purchase product add successfully.');
    }

    public function edit(PurchaseProduct $product) {
        $units = Unit::where('project_id', Auth::user()->project_id)->orderBy('name')->get();
        $segments= ProductSegment::where('project_id', Auth::user()->project_id)->orderBy('name')->get();

        return view('purchase.product.edit', compact('units', 'product','segments'));
    }

    public function editPost(PurchaseProduct $product, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $product->project_id = Auth::user()->project_id;
        $product->name = $request->name;
        $product->unit_id = $request->unit;
        $product->code = $request->code;
        $product->estimate_cost = $request->estimate_cost;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('purchase_product')->with('message', 'Purchase product edit successfully.');
    }

    public function productImport(){
        return view('purchase.product.product_import');
    }
    public function productImportPost(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:xls,xlsx'
        ]);
        \Excel::import(new ImportPurchaseProduct,$request->file);
//        Excel::import(new ImportPurchaseProduct(),request()->file('file')->store('files'));
        return redirect()->route('purchase_product')->with('message', 'Purchase product add successfully.');

    }
}
