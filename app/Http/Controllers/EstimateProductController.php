<?php

namespace App\Http\Controllers;

use App\Models\EstimateProduct;
use App\Models\Unit;
use Illuminate\Http\Request;

class EstimateProductController extends Controller
{
    public function index() {
        $products = EstimateProduct::get();
        return view('estimate.product.all', compact('products'));
    }

    public function add() {

        $units = Unit::where('status',1)->get();
        return view('estimate.product.add',compact('units'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required',
            'unit_price' => 'required',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $product = new EstimateProduct();
        $product->name = $request->name;
        $product->unit_id = $request->unit;
        $product->unit_price = $request->unit_price;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('estimate_product')->with('message', 'Estimate product add successfully.');
    }

    public function edit(EstimateProduct $product) {
        $units = Unit::where('status',1)->get();
        return view('estimate.product.edit', compact( 'product','units'));
    }

    public function editPost(EstimateProduct $product, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required',
            'unit_price' => 'required',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $product->name = $request->name;
        $product->unit_id = $request->unit;
        $product->unit_price = $request->unit_price;
        $product->code = $request->code;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return redirect()->route('estimate_product')->with('message', 'Estimate product edit successfully.');
    }
}
