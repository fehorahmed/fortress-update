<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index() {
        $units = Unit::all();

        return view('administrator.unit.all', compact('units'));
    }

    public function add() {
        return view('administrator.unit.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $unit = new Unit();
        $unit->project_id = Auth::user()->project_id;
        $unit->name = $request->name;
        $unit->status = $request->status;
        $unit->save();

        return redirect()->route('unit.all')->with('message', 'Unit add successfully.');
    }

    public function edit(Unit $unit) {
        return view('administrator.unit.edit', compact('unit'));
    }

    public function editPost(Unit $unit, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,'.$unit->id,
            'status' => 'required'
        ]);

        $unit->project_id = Auth::user()->project_id;
        $unit->name = $request->name;
        $unit->status = $request->status;
        $unit->save();

        return redirect()->route('unit.all')->with('message', 'Unit edit successfully.');
    }

    public function datatable()
    {
        $query = Unit::where('project_id',Auth::user()->project_id);

        return DataTables::eloquent($query)
            ->addColumn('action', function (Unit $unit) {
                return '<a class="btn btn-info btn-sm" href="' . route('unit.edit', ['unit' => $unit->id]) . '">Edit</a>';
            })
            ->editColumn('status', function (Unit $unit) {
                if ($unit->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }

}
