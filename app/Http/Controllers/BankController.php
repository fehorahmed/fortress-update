<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index() {
//        $projects = Project::where('project_id', Auth::user()->project_id)->where('status',1)->get();
        $banks = Bank::where('project_id', Auth::user()->project_id)->get();

        return view('bank_n_account.bank.all', compact('banks'));
    }

    public function add() {
        return view('bank_n_account.bank.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $bank = new Bank();
        $bank->name = $request->name;
        $bank->project_id = Auth::user()->project_id??'';
        $bank->status = $request->status;
        $bank->save();

        return redirect()->route('bank')->with('message', 'Bank add successfully.');
    }

    public function edit(Bank $bank) {
        return view('bank_n_account.bank.edit', compact('bank'));
    }

    public function editPost(Bank $bank, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required'
        ]);

        $bank->project_id = Auth::user()->project_id??'';
        $bank->name = $request->name;
        $bank->status = $request->status;
        $bank->save();

        return redirect()->route('bank')->with('message', 'Bank edit successfully.');
    }
}
