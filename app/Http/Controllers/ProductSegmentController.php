<?php

namespace App\Http\Controllers;

use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductSegmentController extends Controller
{

    public function segmentProjects(){
        $projects = Project::where('id',Auth::user()->project_id)->where('status', 1)->get();
        return view('purchase.segment.projects', compact('projects'));

    }

    public function index(Project $project) {
        $segments=ProductSegment::where('project_id',Auth::user()->project_id)->orderBy('project_id')->get();
        return view('purchase.segment.all', compact('segments','project'));
    }

    public function segmentAdd() {
        $projects= Project::where('id',Auth::user()->project_id)->where('status',1)->get();
        return view('purchase.segment.add',compact('projects'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => [
                'required','max:255','string',
                Rule::unique('product_segments')
                    ->where('name', $request->name)
                    ->where('project_id', Auth::user()->project_id)
            ],
            //'project' => 'required',
            'description' => 'nullable|string|max:255',
            'segment_percentage' => 'required|numeric|max:100|min:0',
            'total_unit' => 'required|numeric|min:0',
            'status' => 'required'
        ]);

        $totalProjectPercentage = ProductSegment::where('project_id',Auth::user()->project_id)->sum('segment_percentage');
        if($totalProjectPercentage + $request->segment_percentage>100){
            return redirect()->back()->withInput()->with('message','Total Project Percentage is more then 100');
        }

        $segment = new ProductSegment();
        $segment->name = $request->name;
        $segment->project_id = Auth::user()->project_id;
        $segment->description = $request->description;
        $segment->segment_percentage = $request->segment_percentage;
        $segment->total_unit = $request->total_unit;
        $segment->status = $request->status;
        $segment->save();

        return redirect()->route('segment.projects')->with('message', 'Product Segment add successfully.');
    }

    public function edit(ProductSegment $segment) {

        $projects= Project::all();
        return view('purchase.segment.edit', compact( 'segment','projects'));
    }

    public function editPost(ProductSegment $segment, Request $request) {
        $request->validate([
            'name' => [
                'required','max:255','string',
                Rule::unique('product_segments')
                    ->ignore($segment)
                    ->where('name', $request->name)
                    ->where('project_id', Auth::user()->project_id)
            ],
            //'project' => 'required',
            'description' => 'nullable|string|max:255',
            'segment_percentage' => 'required|numeric|max:100|min:0',
            'total_unit' => 'required|numeric|min:0',
            'status' => 'required'
        ]);

        $segment->name = $request->name;
        $segment->description = $request->description;
        $segment->project_id = Auth::user()->project_id;
        $segment->segment_percentage = $request->segment_percentage;
        $segment->total_unit = $request->total_unit;
        $segment->status = $request->status;
        $segment->save();

        return redirect()->route('segment',['project'=>$segment->project_id])->with('message', 'Product Segment edit successfully.');
    }
}
