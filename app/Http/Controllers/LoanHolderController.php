<?php

namespace App\Http\Controllers;

use App\Models\LoanHolder;
use Illuminate\Http\Request;

class LoanHolderController extends Controller
{
    public function index() {
        $loanHolders = LoanHolder::where('project_id',auth()->user()->project_id)
                        ->where('status',1)->get();
        return view('loan.loan_holder.all', compact('loanHolders'));
    }

    public function add() {
        return view('loan.loan_holder.add');
    }

    public function addPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'nullable|digits:11',
            'email' => 'nullable|email|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $loanHolder = new LoanHolder();
        $loanHolder->project_id = auth()->user()->project_id;
        $loanHolder->name = $request->name;
        $loanHolder->mobile = $request->mobile_no;
        $loanHolder->email = $request->email;
        $loanHolder->address = $request->address;
        $loanHolder->status = $request->status;
        $loanHolder->save();

        return redirect()->route('loan_holder')->with('message', 'Loan Holder add successfully.');
    }

    public function edit(LoanHolder $loanHolder) {
        return view('loan.loan_holder.edit', compact('loanHolder'));
    }

    public function editPost(LoanHolder $loanHolder, Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'nullable|digits:11',
            'email' => 'nullable|email|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required'
        ]);

        $loanHolder->name = $request->name;
        $loanHolder->project_id = auth()->user()->project_id;
        $loanHolder->mobile = $request->mobile_no;
        $loanHolder->email = $request->email;
        $loanHolder->address = $request->address;
        $loanHolder->status = $request->status;
        $loanHolder->save();

        return redirect()->route('loan_holder')->with('message', 'Loan Holder edit successfully.');
    }

}
