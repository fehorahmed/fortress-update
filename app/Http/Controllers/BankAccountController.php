<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Branch;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function index() {
        $accounts = BankAccount::where('project_id',Auth::user()->project_id)->with('bank', 'branch')->get();

        return view('bank_n_account.account.all', compact('accounts'));
    }

    public function add() {
        $banks = Bank::where('project_id',Auth::user()->project_id)->orderBy('name')->get();

        return view('bank_n_account.account.add', compact('banks'));
    }

    public function addPost(Request $request) {
        $request->validate([
            'bank' => 'required',
            'branch' => 'required',
            'account_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:255',
            'account_code' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'opening_balance' => 'required|numeric|min:0',
            'status' => 'required'
        ]);

        $account = new BankAccount();
        $account->project_id = Auth::user()->project_id??'';
        $account->bank_id = $request->bank;
        $account->branch_id = $request->branch;
        $account->account_name = $request->account_name;
        $account->account_no = $request->account_no;
        $account->account_code = $request->account_code;
        $account->description = $request->description;
        $account->opening_balance = $request->opening_balance;
        $account->balance = $request->opening_balance;
        $account->status = $request->status;
        $account->save();

        return redirect()->route('bank_account')->with('message', 'Bank account add successfully.');
    }

    public function edit(BankAccount $account) {
        $banks = Bank::orderBy('name')->get();

        return view('bank_n_account.account.edit', compact('banks', 'account'));
    }

    public function editPost(BankAccount $account, Request $request) {

        $request->validate([
            'bank' => 'required',
            'branch' => 'required',
            'account_name' => 'required|string|max:255',
            'account_no' => 'required|string|max:255',
            'account_code' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric|min:0',
            'status' => 'required'
        ]);

        $account->project_id = Auth::user()->project_id??'';
        $account->bank_id = $request->bank;
        $account->branch_id = $request->branch;
        $account->account_name = $request->account_name;
        $account->account_no = $request->account_no;
        $account->account_code = $request->account_code;
        $account->description = $request->description;
        $account->opening_balance = $request->opening_balance;
        $account->balance =$account->balance+$request->opening_balance;
        $account->status = $request->status;
        $account->save();

        return redirect()->route('bank_account')->with('message', 'Bank account edit successfully.');
    }

    public function getBranches(Request $request) {
        $branches = Branch::where('bank_id', $request->bankId)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($branches);
    }
}
