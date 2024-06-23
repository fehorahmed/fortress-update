<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index() {
        $branches = Branch::where('project_id', Auth::user()->project_id)->with('bank')->get();

        return view('bank_n_account.branch.all', compact('branches'));
    }

    public function add() {
        $banks = Bank::orderBy('name')->get();

        return view('bank_n_account.branch.add', compact('banks'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'bank' => 'required',
            'status' => 'required'
        ]);

        $branch = new Branch();
        $branch->project_id = Auth::user()->project_id??'';
        $branch->bank_id = $request->bank;
        $branch->name = $request->name;
        $branch->status = $request->status;
        $branch->save();

        return redirect()->route('branch')->with('message', 'Branch add successfully.');
    }

    public function edit(Branch $branch) {
        $banks = Bank::orderBy('name')->get();

        return view('bank_n_account.branch.edit', compact('banks', 'branch'));
    }

    public function editPost(Branch $branch, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'bank' => 'required',
            //'project' => 'required',
            'status' => 'required'
        ]);

        $branch->project_id = Auth::user()->project_id??'';
        $branch->bank_id = $request->bank;
        $branch->name = $request->name;
        $branch->status = $request->status;
        $branch->save();

        return redirect()->route('branch')->with('message', 'Branch edit successfully.');
    }
}
