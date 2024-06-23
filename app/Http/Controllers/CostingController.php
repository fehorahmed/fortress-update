<?php

namespace App\Http\Controllers;

use App\Models\Costing;
use App\Models\CostingSegment;
use App\Models\EstimateProduct;
use App\Models\EstimateProductCosting;
use App\Models\EstimateProject;
use App\Models\ProductRequisition;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductProductCosting;
use App\Models\Requisition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SakibRahaman\DecimalToWords\DecimalToWords;
use Yajra\DataTables\Facades\DataTables;

class CostingController extends Controller
{

    public function allProjects() {

        $projects= Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        return view('estimate.costing.projects',compact('projects'));
    }
    public function index(Project $project) {
        $costing = Costing::where('estimate_project_id',Auth::user()->project_id)->get();
        return view('estimate.costing.all',compact('costing','project'));
    }

    public function add() {
        $estimateProjects = Project::where('id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
        $costingTypes = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->get();
        $purchaseProducts =PurchaseProduct::where('project_id',Auth::user()->project_id)->where('status',1)->get();

        return view('estimate.costing.add', compact('estimateProjects','costingTypes','purchaseProducts'));
    }

    public function addPost(Request $request) {

        $request->validate([
                'estimate_project_id' => 'required',
                'costing_type_id' => 'required',
                'note' => 'nullable|max:255',
                'date' => 'required|date',
                'product.*' => 'required',
                'unit_price.*' => 'required',
                'cost_type.*' => 'required',
                'quantity.*' => 'required|numeric|min:0',
            ]
        );

        $costingCheck= Costing::where('estimate_project_id',$request->estimate_project_id)
            ->where('costing_type_id',$request->costing_type_id)->first();

        if ($costingCheck){
            return redirect()->back()->with('message','This Segment Costing Already Done.');
        }

        $costing = new Costing();
        $costing->estimate_project_id = $request->estimate_project_id;
        $costing->costing_type_id = $request->costing_type_id;
        $costing->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $costing->note = $request->note;
        $costing->total = 0;
        $costing->save();
        $costing->estimate_costing_id =  1000000+$costing->id;

        $counter = 0;
        $total = 0;
        foreach ($request->product as $reqProduct) {
            $product = PurchaseProduct::find($reqProduct);

            PurchaseProductProductCosting::create([
                'costing_id' => $costing->id,
                'purchase_product_id' => $product->id,
                'name' => $product->name,
                'unit_id' => $product->unit->id,
                'unit_price' => $request->unit_price[$counter],
                'cost_type' => $request->cost_type[$counter],
                'quantity' => $request->quantity[$counter],
                'costing_amount' => $request->unit_price[$counter] * $request->quantity[$counter],
            ]);

            $total += $request->unit_price[$counter] * $request->quantity[$counter];
            $counter++;
        }
        $costing->total = $total;
        $costing->save();

        return redirect()->route('costing.details', ['costing' => $costing->id]);
    }

    public function edit(Costing $costing){
        $products = PurchaseProduct::where('project_id',Auth::user()->project_id)->get();
        $estimateProjects = Project::where('id',$costing->estimate_project_id)->where('status', 1)->orderBy('name')->get();
        $costingTypes = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->get();
        return view('estimate.costing.edit', compact('estimateProjects','costing','costingTypes','products'));
    }
    public function editPost(Request $request,Costing $costing){
        $request->validate([
            'estimate_project_id' => 'required',
            'costing_type_id' => 'required',
            'note' => 'nullable|max:255',
            'date' => 'required|date',
            'product.*' => 'required',
            'unit_price.*' => 'required',
            'cost_type.*' => 'required',
            'quantity.*' => 'required|numeric|min:0',
        ]);

        $costing->estimate_project_id = $request->estimate_project_id;
        $costing->costing_type_id = $request->costing_type_id;
        $costing->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $costing->note = $request->note;
        $costing->total = 0;
        $costing->save();

        PurchaseProductProductCosting::where('costing_id',$costing->id)->delete();

        $counter = 0;
        $total = 0;
        foreach ($request->product as $reqProduct) {
            $product = PurchaseProduct::find($reqProduct);

            PurchaseProductProductCosting::create([
                'costing_id' => $costing->id,
                'purchase_product_id' => $product->id,
                'name' => $product->name,
                'unit_id' => $product->unit->id,
                'unit_price' => $request->unit_price[$counter],
                'quantity' => $request->quantity[$counter],
                'cost_type' => $request->cost_type[$counter],
                'costing_amount' => $request->unit_price[$counter] * $request->quantity[$counter],
            ]);

            $total += $request->unit_price[$counter] * $request->quantity[$counter];
            $counter++;
        }
        $costing->total = $total;
        $costing->save();

        return redirect()->route('costing.details', ['costing' => $costing->id]);

    }

    public function details(Costing $costing) {
        $costing->amount_in_word = DecimalToWords::convert($costing->total,'Taka',
            'Poisa');
        $date =  Carbon::createFromFormat('Y-m-d', $costing->date)->format('d-m-Y');
        return view('estimate.costing.details', compact('costing','date'));
    }

    public function reportDetails(Budget $budget) {
        $budget->amount_in_word = DecimalToWords::convert($budget->total,'Taka',
            'Poisa');

        $budgetProducts = BudgetProduct::where('budget_id',$budget->id)->get();

        foreach ($budgetProducts as $budgetProduct){

            $totalProductExpenses = DB::table('purchase_order_purchase_product')->where('estimate_product_id',$budgetProduct->purchase_product_id)->get();

            return view('budget.report_details', compact('budget','totalProductExpenses'));

        }
    }

    public function costingDatatable() {
        $query = Costing::where('estimate_project_id',Auth::user()->project_id)->with('project');

        return DataTables::eloquent($query)
            ->addColumn('project', function(Costing $costing) {
                return $costing->project->name??'';
            })
            ->addColumn('segment', function(Costing $costing) {
                return $costing->segment->name??'';
            })
            ->addColumn('action', function(Costing $costing) {

                return '<a href="'.route('costing.details', ['costing' => $costing->id]).'" class="btn btn-primary btn-sm">View</a> <a href="'.route('costing.edit', ['costing' => $costing->id]).'" class="btn btn-info btn-sm">Edit</a>';

            })
            ->editColumn('date', function(Costing $costing) {
                return $costing->date;
            })
            ->editColumn('total', function(Costing $costing) {
                return '৳ '.number_format($costing->total, 2);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function costingReport(Request $request){
      //  dd('dsf');
        $projects = Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        $costingTypes = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->get();
        $costings = [];
        $expenses = null;

        if (!empty($request->project)) {
            $costings = Costing::with('project')->where('estimate_project_id',$request->project)->get();
        }
        return view('estimate.report.costing_report', compact('projects','costings','costingTypes'));

    }

    public function estimateProductJson(Request $request) {

                 $costingId= Costing::where('estimate_project_id',$request->projectId)
                     ->where('costing_type_id',$request->segmentId)->first();

                 $costingQuantity= PurchaseProductProductCosting::where('costing_id',$costingId->id)
                     ->where('purchase_product_id',$request->productId)
                     ->sum('quantity');

                 $requisitionIds= Requisition::where('project_id',$request->projectId)
                     ->where('product_segment_id',$request->segmentId)
                     ->pluck('id');
                 $requisitionQuantity= ProductRequisition::whereIn('requisition_id',$requisitionIds)
                     ->where('purchase_product_id',$request->productId)
                     ->sum('quantity');

                 $available= $costingQuantity-$requisitionQuantity;

            $product = PurchaseProduct::findOrFail($request->productId);

            $unit= $product->unit->name;

        return response()->json(['success' => true, 'data' => $product,'unit'=>$unit,'available'=>$available]);
        //echo json_encode($data);
    }


    public function estimateProductJsonEdit(Request $request) {

        $costingId= Costing::where('estimate_project_id',$request->projectId)
            ->where('costing_type_id',$request->segmentId)->first();

        $costingQuantity= PurchaseProductProductCosting::where('costing_id',$costingId->id)
            ->where('purchase_product_id',$request->productId)
            ->sum('quantity');

        $exceptid= $request->requisitionId;

        $requisitionIds= Requisition::whereNotIn('id',[$exceptid])
            ->where('project_id',$request->projectId)
            ->where('product_segment_id',$request->segmentId)
            ->pluck('id');
        $requisitionQuantity= ProductRequisition::whereIn('requisition_id',$requisitionIds)
            ->where('purchase_product_id',$request->productId)
            ->sum('quantity');

        $available= $costingQuantity-$requisitionQuantity;

        $product = PurchaseProduct::findOrFail($request->productId);

        $unit= $product->unit->name;

        return response()->json(['success' => true, 'data' => $product,'unit'=>$unit,'available'=>$available]);
        //echo json_encode($data);
    }


    public function estimateProductDetails(Request $request) {
        $product = PurchaseProduct::where('id', $request->productId)
            ->where('project_id',Auth::user()->project_id)
            ->first();

        $unit=$product->unit->name;
        if ($product) {
            $product = $product->toArray();
            return response()->json(['success' => true, 'data' => $product,'unit_name'=>$unit]);
        } else {
            return response()->json(['success' => false, 'message' => 'Not found.']);
        }
    }
}
