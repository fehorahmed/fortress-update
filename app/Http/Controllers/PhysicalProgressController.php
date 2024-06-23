<?php

namespace App\Http\Controllers;

use App\Models\PhysicalProgress;
use App\Models\ProductSegment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PhysicalProgressController extends Controller
{

    public function index()
    {
        return view('administrator.project.physical_progress.all');
    }


    public function add()
    {
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)->where('status',1)->get();

        return view('administrator.project.physical_progress.add',compact('segments'));
    }


    public function addPost(Request $request)
    {
        $request->validate([
            'segment'=>'required',
            'total_unit'=>'required',
            'segment_percentage'=>'required',
            'date'=>'required|date',
            'unit_complete'=>'required|min:0',
            'progress'=>'required|numeric|max:'.($request->total_unit-$request->unit_complete),
        ]);
        $segment = ProductSegment::find($request->segment);
        if(!$segment){
            return redirect()->back()->with('message','Segement Error!!');
        }

       $segmentPercentage= ($request->progress*100)/$segment->total_unit;
       $projectPercentage= ($segmentPercentage*$segment->segment_percentage)/100;


        $physicalProgress= new PhysicalProgress();
        $physicalProgress->project_id=Auth::user()->project_id;
        $physicalProgress->product_segment_id=$request->segment;
        $physicalProgress->daily_unit_done = $request->progress;

        $physicalProgress->segment_progress_percentage = $segmentPercentage;
        $physicalProgress->project_progress_percentance = $projectPercentage;
        $physicalProgress->date = date("Y-m-d", strtotime($request->date));
        $physicalProgress->note = $request->note;
        $physicalProgress->user_id = Auth::id();
        $physicalProgress->save();

        $segment->increment('unit_done',$request->progress);

        return redirect()->route('physical.project.all')->with('message','Progress Added Successfully');
    }


    public function projectWiseView(Project $project)
    {
        $physicalProgress= PhysicalProgress::where('project_id',Auth::user()->project_id)->orderBy('date','desc')->get();

        return view('administrator.project.physical_progress.project_wise_view',compact('physicalProgress','project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhysicalProgress  $physicalProgress
     * @return \Illuminate\Http\Response
     */
    public function edit(PhysicalProgress $physicalProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhysicalProgress  $physicalProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhysicalProgress $physicalProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhysicalProgress  $physicalProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhysicalProgress $physicalProgress)
    {
        //
    }
    public function progressDatatable()
    {
        $query = Project::where('id',Auth::user()->project_id);

        return DataTables::eloquent($query)
            ->addColumn('action', function (Project $project) {
                return '<a class="btn btn-info btn-sm" href="'.route('physical_progress_view',['project'=>$project->id]).'">View</a>';
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

    public function report(Request $request){
        $start_date = date("Y-m-d", strtotime($request->start));
        $end_date = date("Y-m-d", strtotime($request->end));

        $progresses=[];
        $projects= Project::where('id',Auth::user()->project_id);

        $segments= [];

        if ($start_date && $start_date !='' && $end_date && $end_date){
            $segments = ProductSegment::where('project_id',$request->project)->get();
            $query= PhysicalProgress::where('project_id', Auth::user()->project_id);
            if ($start_date && $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            }
            $progresses=$query->get();
        }

        return view('report.physical_report',compact('projects','progresses','segments'));
    }
}
