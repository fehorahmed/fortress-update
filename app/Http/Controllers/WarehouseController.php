<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('administrator.warehouse.all');
    }

    public function add()
    {
        $projects = Project::where('status',1)->get();
        return view('administrator.warehouse.add',compact('projects'));
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:warehouses',
            //'project' => 'required',
            'address' => 'nullable',
            'status' => 'required'
        ]);

        $warehouse = new Warehouse();
        $warehouse->project_id = Auth::user()->project_id??'';
        $warehouse->name = $request->name;
        $warehouse->address = $request->address;
        $warehouse->status = $request->status;
        $warehouse->save();

        return redirect()->route('warehouse.all')->with('message', 'Warehouse add successfully.');
    }

    public function edit(Warehouse $warehouse)
    {
        $projects = Project::where('status',1)->get();
        return view('administrator.warehouse.edit', compact('warehouse','projects'));
    }

    public function editPost(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'project' => 'required',
            'address' => 'nullable',
            'status' => 'required'
        ]);

        $warehouse->project_id = Auth::user()->project_id??'';
        $warehouse->name = $request->name;
        $warehouse->address = $request->address;
        $warehouse->status = $request->status;
        $warehouse->save();

        return redirect()->route('warehouse.all')->with('message', 'Warehouse update successfully.');
    }

    public function datatable()
    {
        $query = Warehouse::where('project_id',Auth::user()->project_id);

        return DataTables::eloquent($query)
            ->addColumn('action', function (Warehouse $warehouse) {
                return '<a class="btn btn-info btn-sm" href="' . route('warehouse.edit', ['warehouse' => $warehouse->id]) . '">Edit</a>';
            })
//            ->editColumn('project', function (Warehouse $warehouse) {
//                return $warehouse->project->name??'';
//            })
            ->editColumn('status', function (Warehouse $warehouse) {
                if ($warehouse->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }
}
