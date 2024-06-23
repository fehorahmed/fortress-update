<?php

namespace App\Http\Controllers;

use App\Models\CostingSegment;
use App\Models\EstimateProject;
use Illuminate\Http\Request;

class CostingSegmentController extends Controller
{
    public function index() {
        $costingSegments = CostingSegment::all();
       // dd($costingSegments);
        return view('estimate.costing_segment.all', compact('costingSegments'));
    }

    public function add() {
        $projects= EstimateProject::where('status',1)->get();
        return view('estimate.costing_segment.add',compact('projects'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'project' => 'required',
            'description' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $costingSegment = new CostingSegment();
        $costingSegment->name = $request->name;
        $costingSegment->project_id = $request->project;
        $costingSegment->description = $request->description;
        $costingSegment->status = $request->status;
        $costingSegment->save();

        return redirect()->route('costing_segment')->with('message', 'Costing Type add successfully.');
    }

    public function edit(CostingSegment $costingSegment) {
        $projects= EstimateProject::where('status',1)->get();
        return view('estimate.costing_segment.edit', compact( 'costingSegment','projects'));
    }

    public function editPost(CostingSegment $costingSegment, Request $request) {
        //dd($costingSegment);
        $request->validate([
            'name' => 'required|string|max:255',
            'project' => 'required',
            'description' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $costingSegment->name = $request->name;
        $costingSegment->project_id = $request->project;
        $costingSegment->description = $request->description;
        $costingSegment->status = $request->status;
        $costingSegment->save();

        return redirect()->route('costing_segment')->with('message', 'Costing Type edit successfully.');
    }
}
