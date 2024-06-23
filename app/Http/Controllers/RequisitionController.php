<?php

namespace App\Http\Controllers;

use App\Models\Costing;
use App\Models\CostingSegment;
use App\Models\EstimateProduct;
use App\Models\EstimateProject;
use App\Models\ProductPurchaseOrder;
use App\Models\ProductRequisition;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\PurchaseInventory;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductProductCosting;
use App\Models\Requisition;
use App\Models\User;
use App\Notifications\NewRequisitionNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use SakibRahaman\DecimalToWords\DecimalToWords;
use Yajra\DataTables\Facades\DataTables;

class RequisitionController extends Controller
{

    public function index()
    {
        $estimateProjects = Project::where('id', Auth::user()->project_id)->where('status', 1)->get();

        return view('requisition.all', compact('estimateProjects'));
    }

    public function requisitionSegmentView(Project $project)
    {

        $costings = Costing::where('estimate_project_id', $project->id)->get();

        return view('requisition.all_segment', compact('costings', 'project'));
    }


    public function edit(Costing $costing)
    {
        $products = PurchaseProduct::where('project_id', Auth::user()->project_id)->where("status", 1)->get();
        $estimateProjects = Project::where('id', $costing->estimate_project_id)->where('status', 1)->orderBy('name')->get();
        $costingTypes = ProductSegment::where('project_id', Auth::user()->project_id)->where('id', $costing->costing_type_id)->where('status', 1)->get();
        return view('requisition.edit', compact('estimateProjects', 'costing', 'costingTypes', 'products'));
    }

    public function editPost(Request $request, Costing $costing)
    {
        $request->validate([
            'estimate_project_id' => 'required',
            'costing_type_id' => 'required',
            'note' => 'nullable|max:255',
            'date' => 'required|date',
            'product.*' => 'required',
            'unit_price.*' => 'required',
            'quantity.*' => 'required|numeric|min:0',
        ]);

        $requisition = Requisition::where('costing_id', $costing->id)
            ->where('project_id', Auth::user()->project_id)
            ->first();
        if ($requisition) {
            $requisition->estimate_project_id = $request->estimate_project_id;
            $requisition->costing_type_id = $request->costing_type_id;
            //   $requisition->costing_id = $costing->id;

            $requisition->date = $request->date;
            $requisition->note = $request->note;
            $requisition->total = 0;
            $requisition->save();

            ProductRequisition::where('requisition_id', $requisition->id)->delete();

            $counter = 0;
            $total = 0;
            foreach ($request->product as $reqProduct) {
                $product = PurchaseProduct::find($reqProduct);
                ProductRequisition::create([
                    'requisition_id' => $requisition->id,
                    'purchase_product_id' => $product->id,
                    'name' => $product->name,
                    'unit_id' => $product->unit->id,
                    'unit_price' => $request->unit_price[$counter],
                    'quantity' => $request->quantity[$counter],
                    'costing_amount' => $request->unit_price[$counter] * $request->quantity[$counter],
                ]);
                $total += $request->unit_price[$counter] * $request->quantity[$counter];
                $counter++;
            }
            $requisition->total = $total;
            $requisition->save();

            $costing->costing_done_status = 1;
            $costing->save();

            return redirect()->route('requisition.details', ['requisition' => $requisition->id]);
        } else {
            $newRequisition = new Requisition();
            $newRequisition->estimate_project_id = $request->estimate_project_id;
            $newRequisition->costing_type_id = $request->costing_type_id;
            $newRequisition->costing_id = $costing->id;
            $newRequisition->date = $request->date;
            $newRequisition->note = $request->note;
            $newRequisition->total = 0;
            $newRequisition->save();
            $counter = 0;
            $total = 0;
            foreach ($request->product as $reqProduct) {
                $product = PurchaseProduct::find($reqProduct);

                ProductRequisition::create([
                    'requisition_id' => $newRequisition->id,
                    'purchase_product_id' => $product->id,
                    'name' => $product->name,
                    'unit_id' => $product->unit->id,
                    'unit_price' => $request->unit_price[$counter],
                    'quantity' => $request->quantity[$counter],
                    'costing_amount' => $request->unit_price[$counter] * $request->quantity[$counter],
                ]);

                $total += $request->unit_price[$counter] * $request->quantity[$counter];
                $counter++;
            }

            $newRequisition->total = $total;
            $newRequisition->save();
            $costing->costing_done_status = 1;
            $costing->save();

            return redirect()->route('requisition.details', ['requisition' => $newRequisition->id]);
        }
    }

    public function details(Requisition $requisition)
    {
        $requisition->amount_in_word = DecimalToWords::convert(
            $requisition->total,
            'Taka',
            'Poisa'
        );
        return view('requisition.details', compact('requisition'));
    }


    public function requisitionViewDatatable()
    {
        $query = Project::where('id', Auth::user()->project_id);

        return DataTables::eloquent($query)
            ->addColumn('action', function (Project $project) {
                return '<a class="btn btn-info btn-sm" href="' . route('segment.view', ['project' => $project->id]) . '">View Segment</a>';
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

    public function all($costing)
    {

        $requisitions = Requisition::where('project_id', Auth::user()->project_id)->where('costing_id', $costing)->get();

        return view('requisition.view.all', compact('requisitions'));
    }

    public function add(Costing $costing)
    {

        $productIds = PurchaseProductProductCosting::where('costing_id', $costing->id)->pluck('purchase_product_id');
        $purchaseProducts = PurchaseProduct::whereIn('id', $productIds)->get();
        return view('requisition.add', compact(
            'purchaseProducts',
            'costing'
        ));
    }

    public function addPost(Request $request, Costing $costing)
    {
        $request->validate([
            'project' => 'required',
            'segment' => 'required',
            'note' => 'nullable|max:255',
            'date' => 'required|date',
            'product.*' => 'required',
            'available.*' => 'required',
            'unit.*' => 'required',
            'quantity.*' => 'required|numeric|min:0|lte:available.*',
        ]);

        $requisition = new Requisition();
        $requisition->project_id = $request->project;
        $requisition->product_segment_id = $request->segment;
        $requisition->costing_id = $costing->id;
        $requisition->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')  ;
        $requisition->note = $request->note;
        $requisition->quantity = 0;
        $requisition->user_id = Auth::id();
        $requisition->save();
        $requisition->id_no = ($request->project.'0000')+$requisition->id;
        $requisition->save();

        $counter = 0;
        $total = 0;
        foreach ($request->product as $reqProduct) {
            $product = PurchaseProduct::find($reqProduct);

            ProductRequisition::create([
                'requisition_id' => $requisition->id,
                'purchase_product_id' => $product->id,
                'name' => $product->name,
                'unit_id' => $product->unit->id,
                'quantity' => $request->quantity[$counter],
            ]);

            $total += $request->quantity[$counter];
            $counter++;
        }

        $requisition->quantity = $total;
        $requisition->save();

        // Send Notification
        $vendorUsers = User::where('role', 0)->get();
        // dd($vendorUsers);
        Notification::send($vendorUsers, new NewRequisitionNotification($requisition));



        return redirect()->route('segment.view', ['project' => $requisition->project_id])->with('message', 'Requisition Add successful.');
    }

    public function requisitionDatatable()
    {
        $query = Requisition::where('requisition_done_status', null)->with('project');

        return DataTables::eloquent($query)
            ->addColumn('project', function (Requisition $requisition) {
                return $requisition->project->name ?? '';
            })
            ->addColumn('segment', function (Requisition $requisition) {
                return $requisition->segment->name ?? '';
            })
            ->addColumn('action', function (Requisition $requisition) {

                if ($requisition->requisition_done_status == 1) {
                    return '<a href="' . route('requisition.details', ['requisition' => $requisition->id]) . '" class="btn btn-primary btn-sm">View</a>
                <button class="btn btn-info btn-sm">Requisition done</button>';
                } else {
                    return '<a href="' . route('requisition.details', ['requisition' => $requisition->id]) . '" class="btn btn-primary btn-sm">View</a>';
                }
            })
            ->editColumn('date', function (Requisition $costing) {
                return $costing->date;
            })
            ->editColumn('total', function (Requisition $costing) {
                return '৳ ' . number_format($costing->total, 2);
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function viewEdit(Requisition $requisition)
    {
        $productIds = PurchaseProductProductCosting::where('costing_id', $requisition->costing_id)->pluck('purchase_product_id');
        $products = PurchaseProduct::whereIn('id', $productIds)->get();
        return view('requisition.view.edit', compact('requisition', 'products'));
    }

    public function viewEditPost(Requisition $requisition, Request $request)
    {
        $request->validate([
            'project' => 'required',
            'segment' => 'required',
            'note' => 'nullable|max:255',
            'date' => 'required|date',
            'product.*' => 'required',
            'available.*' => 'required',
            'unit.*' => 'required',
            'quantity.*' => 'required|numeric|min:0|lte:available.*',
        ]);

        $requisition->project_id = $request->project;
        $requisition->product_segment_id = $request->segment;
        // $requisition->costing_id = $costing->id;
        $requisition->date =  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')  ;
        $requisition->note = $request->note;
        $requisition->quantity = 0;
        $requisition->save();

        ProductRequisition::where('requisition_id', $requisition->id)->delete();
        $counter = 0;
        $total = 0;
        foreach ($request->product as $reqProduct) {
            $product = PurchaseProduct::find($reqProduct);

            ProductRequisition::create([
                'requisition_id' => $requisition->id,
                'purchase_product_id' => $product->id,
                'name' => $product->name,
                'unit_id' => $product->unit->id,
                'quantity' => $request->quantity[$counter],
            ]);

            $total += $request->quantity[$counter];
            $counter++;
        }

        $requisition->quantity = $total;
        $requisition->save();
        return redirect()->route('segment.view', ['project' => $requisition->project_id])->with('message', 'Requisition Add successful.');
    }

    public function requisitionReport(Request $request)
    {

        // dd('sdfds');
        $projects = Project::where('id',Auth::user()->project_id)->where('status', 1)->get();
        $costingTypes = [];
        $requisitions = [];
        $expenses = null;

        if (!empty($request->project)) {
            $costingTypes = ProductSegment::where('project_id', Auth::user()->project_id)->get();
            $requisitions = Requisition::with('project')->where('project_id', Auth::user()->project_id)->get();
        }
        return view('requisition.report', compact('projects', 'requisitions', 'costingTypes'));
    }


    public function requisitionToReal(Requisition $requisition)
    {

        //  dd( $requisition->estimateProject->name);

        $productSegment = ProductSegment::where('estimate_project_id', $requisition->estimate_project_id)
            ->where('costing_segment_id', $requisition->costing_type_id)->first();
        if ($productSegment) {
            return redirect()->back()->with('message', 'Estimate Project Segment Already in the Project list');
        } else {

            $project = Project::where('estimate_project_id', $requisition->estimate_project_id)->first();
            if ($project) {
            } else {
                $project = new Project();
                $project->name = $requisition->estimateProject->name;
                $project->estimate_project_id = $requisition->estimateProject->id;
                $project->address = $requisition->estimateProject->address;
                $project->status = 1;
                $project->save();

                $estimateProject = EstimateProject::findOrFail($requisition->estimate_project_id);
                $estimateProject->project_id = $project->id;
                $estimateProject->save();
            }


            $projectSegment = new ProductSegment();
            $projectSegment->project_id = $project->id;
            $projectSegment->name = $requisition->estimateSegment->name;
            $projectSegment->description = $requisition->estimateSegment->description;
            $projectSegment->estimate_project_id = $requisition->estimate_project_id;
            $projectSegment->costing_segment_id = $requisition->costing_type_id;
            $projectSegment->status = 1;
            $projectSegment->save();


            $requisition->requisition_done_status = 1;
            $requisition->save();

            return redirect()->back()->with('message', 'Segment Added Successfully');
        }
    }

    public function purchaseRequisition(Request $request)
    {
        $projects = Project::where('id', Auth::user()->project_id)->get();
        $originalProject = [];
        $currentProject = [];
        $purchases = [];
        $requisitions = [];
        $products = [];

        if ($request->project) {
            $currentProject= Project::find($request->project);
            $requisitionIds = Requisition::where('project_id', $request->project)->pluck('id');
            $requisitions = ProductRequisition::whereIn('requisition_id', $requisitionIds)
                ->selectRaw('SUM(quantity)as total,purchase_product_id')
                ->orderBy('purchase_product_id')
                ->groupBy('purchase_product_id')
                ->get();
               // ->pluck('purchase_product_id');
           // dd($requisitions);

        }

        return view('report.purchase_requisition_report', compact('projects',
            'purchases', 'requisitions', 'products','currentProject'));
    }

    public function requisitionBoqReport(Request $request)
    {
        $projects = Project::where('id', Auth::user()->project_id)->get();
        $requisitionProject = [];
        $requisitionProducts = [];
        $boqs = [];
        $costingProducts = [];
        $products = [];

        if ($request->project && $request->segment == '') {
            $project = Project::find($request->project);
            $costingProducts = Costing::where('estimate_project_id', $project->id)->get();
            //  $costingProducts = PurchaseProductProductCosting::whereIn('costing_id', $costingIds)->get();
            // dd('sd');
        }
        if ($request->project && $request->segment) {
            $project = Project::find($request->project);

            $costingProducts = Costing::where('estimate_project_id', $project->id)
                ->where('costing_type_id', $request->segment)
                ->get();



            //  $costingProducts = PurchaseProductProductCosting::whereIn('costing_id', $costingIds)->get();

        }

        return view('report.boq_requisition_report', compact('projects', 'costingProducts'));
    }
}
