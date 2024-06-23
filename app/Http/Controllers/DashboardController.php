<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductUtilize;
use App\Models\Stakeholder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        if (Auth::user()->admin_status == 1 && Auth::user()->role == 3) {
            $projects=Project::orderBy('id')->get();
            $stakeholder_count= Stakeholder::all()->count();
            $supplier_count= Supplier::all()->count();
            $product_count= PurchaseProduct::all()->count();
            $todayOrders = PurchaseOrder::where('date',date('Y-m-d'))->get();
            $todayUtilizes = PurchaseProductUtilize::where('date',date('Y-m-d'))->get();
        }else{
            $projects=Project::where('id',Auth::user()->project_id)->orderBy('id')->get();
            $stakeholder_count= Stakeholder::where('project_id',Auth::user()->project_id)->get()->count();
            $supplier_count= Supplier::where('project_id',Auth::user()->project_id)->get()->count();
            $product_count= PurchaseProduct::where('project_id',Auth::user()->project_id)->get()->count();
            $todayOrders = PurchaseOrder::where('project_id',Auth::user()->project_id)->where('date',date('Y-m-d'))->get();
            $todayUtilizes = PurchaseProductUtilize::where('project_id',Auth::user()->project_id)->where('date',date('Y-m-d'))->get();

        }
      //  dd($orders);
        //dd($project_count);
        $datas=[
            'project_count'=>$projects->count(),
            'stakeholder_count'=>$stakeholder_count,
            'supplier_count'=>$supplier_count,
            'product_count'=>$product_count,
        ];

        return view('dashboard',compact('projects','datas','todayOrders','todayUtilizes'));
    }
}
