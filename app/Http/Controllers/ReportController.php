<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\ContractorBudget;
use App\Models\ContractorPayment;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\ProjectWiseStakeholder;
use App\Models\PurchaseOrder;
use App\Models\PurchasePayment;
use App\Models\PurchaseProduct;
use App\Models\Stakeholder;
use App\Models\StakeholderPayment;
use App\Models\Contractor;
use App\Models\Supplier;
use App\Models\TransactionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function supplierLedger(Request $request)
    {
        $start_date = $request->start ? date("Y-m-d", strtotime($request->start)) : null;
        $end_date = $request->end ? date("Y-m-d", strtotime($request->end)) : null;

        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $suppliers = Supplier::orderBy('name')->get();
            $query = PurchaseOrder::query();
        } else {
            $suppliers = Supplier::where('project_id', Auth::user()->project_id)->orderBy('name')->get();
            $query = PurchaseOrder::where('project_id', Auth::user()->project_id);
        }

        if ($start_date && $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
        }

        if ($request->supplier && $request->supplier != '') {
            $query->where('supplier_id', $request->supplier);
        }

        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
        $orders = $query->get();

        $appends = [
            'start' => $request->start,
            'end' => $request->end,
            'supplier' => $request->supplier
        ];

        return view('report.supplier_ledger', compact('suppliers', 'orders', 'appends'));
    }


    public function contractorLedger(Request $request)
    {
        $start_date = date("Y-m-d", strtotime($request->start));
        $end_date = date("Y-m-d", strtotime($request->end));

        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $contractors = Contractor::orderBy('name')->get();
            $appends = [];
            $query = ContractorPayment::query();
        } else {
            $contractors = Contractor::where('project_id', Auth::user()->project_id)->orderBy('name')->get();
            $appends = [];
            $query = ContractorPayment::where('project_id', Auth::user()->project_id);
        }

        if ($start_date && $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
            $appends['date'] = $request->date;
        }

        if ($request->contractor && $request->contractor != '') {
            $query->where('contractor_id', $request->contractor);
            $appends['contractor'] = $request->contractor;
        }
        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
        $orders = $query->get();
        return view('report.contractor_ledger', compact('contractors', 'orders', 'appends'));
    }

    public function purchaseReport(Request $request)
    {
        $start_date = $request->start ? date("Y-m-d", strtotime($request->start)) : null;
        $end_date = $request->end ? date("Y-m-d", strtotime($request->end)) : null;

        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $projects = Project::orderBy('name')->get();
            $suppliers = Supplier::orderBy('name')->get();
            $products = PurchaseProduct::orderBy('name')->get();
            $query = PurchaseOrder::with('supplier');
        } else {
            $projects = Project::where('id', Auth::user()->project_id)->orderBy('name')->get();
            $suppliers = Supplier::where('project_id', Auth::user()->project_id)->orderBy('name')->get();
            $products = PurchaseProduct::where('project_id', Auth::user()->project_id)->orderBy('name')->get();
            $query = PurchaseOrder::where('project_id', Auth::user()->project_id)->with('supplier');
        }

        if ($start_date && $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
        }

        if ($request->supplier && $request->supplier != '') {
            $query->where('supplier_id', $request->supplier);
        }

        if ($request->project && $request->project != '') {
            $query->where('project_id', $request->project);
        }

        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        $data = [
            'total' => $query->sum('total'),
            'due' => $query->sum('due'),
            'paid' => $query->sum('paid'),
        ];

        $orders = $query->paginate(10);

        $appends = [
            'start' => $request->start,
            'end' => $request->end,
            'supplier' => $request->supplier,
            'project' => $request->project,
        ];

        return view('report.purchase_report', compact(
            'orders',
            'suppliers',
            'products',
            'appends',
            'projects'
        ))->with($data);
    }


    public function stakeholderReport(Request $request)
    {
        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $segments = ProductSegment::all();
            $stakeholders = Stakeholder::all();
            $projects = Project::all();
            $payments = [];
            $projectStakeholder = [];
        } else {
            $segments = ProductSegment::where('project_id', Auth::user()->project_id)->where('status', 1)->get();
            $stakeholders = Stakeholder::where('project_id', Auth::user()->project_id)->get();
            // dd($stakeholders);
            $projects = Project::where('id', Auth::user()->project_id)->get();
            $payments = [];
            $projectStakeholder = [];
        }

        if ($request->stakeholder && $request->stakeholder != '') {
            $payments = StakeholderPayment::where('project_id', $request->project)
                ->where('stakeholder_id', $request->stakeholder)->get();
            // dd($payments);
            $projectStakeholder = ProjectWiseStakeholder::where('project_id', $request->project)
                ->where('stakeholder_id', $request->stakeholder)->first();
        }

        return view('report.stakeholder_report', compact('stakeholders', 'projectStakeholder', 'projects', 'payments', 'segments'));
    }

    public function projectReport(Request $request)
    {

        //$stakeholdersId = TransactionLog::where('stakeholder_id','!=',null)->groupBy('stakeholder_id')->pluck('stakeholder_id');
        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $projects = Project::where('status', 1)->get();
        } else {
            $projects = Project::where('id', Auth::user()->project_id)->where('status', 1)->get();
        }
        $stakeholders = [];
        $start = null;
        $end = null;
        $incomes = null;
        $expenses = null;
        $totalDuration = null;
        $project = null;
        $otherIncomes = [];
        $otherExpenses = [];
        $supplierPayments = [];
        $contractorPayments = [];
        $supplierDetails = [];
        $datas = [
            'project' => '',
        ];
        // $query = TransactionLog::where('transaction_type',1)->where('stakeholder_id','!=',null);


        if ($request->project && $request->project != '') {
            $stakeholderIds = ProjectWiseStakeholder::where('project_id', $request->project)->pluck('stakeholder_id');
            //dd($stakeholderIds);
            $stakeholders = Stakeholder::whereIn('id', $stakeholderIds)->get();
            $stakeHolderPayments = StakeholderPayment::whereIn('stakeholder_id', $stakeholderIds)->get();
            //dd($stakeHolderPayments);
            $project = Project::find($request->project);
            $incomes = TransactionLog::where('project_id', $request->project)->where('transaction_type', 1)->sum('amount');
            // dd($incomes);
            $expenses = TransactionLog::where('project_id', $request->project)->where('transaction_type', 2)->sum('amount');
            // dd($expenses);
            $start = $project->duration_start;
            $end = $project->duration_end;
            $totalDuration = $project->total_duration;
            $otherIncomes = TransactionLog::where('project_id', $request->project)
                ->where('transaction_type', 1)
                ->where('project_payment_type', 3)->get();
            $otherExpenses = TransactionLog::where('project_id', $request->project)
                ->where('transaction_type', 2)
                ->where('project_payment_type', 3)->get();
            $supplierPayments = Supplier::where('project_id', $request->project)->get();
            $contractorPayments = ContractorBudget::where('project_id', $request->project)->get();
            //            $contractorPayments= Contractor::where('project_id',$request->project)->get();
            $supplierDetails = Supplier::all();
            $datas = [
                'project' => $project,
            ];
        }

        return view('report.project_report', compact(
            'projects',
            'supplierPayments',
            'contractorPayments',
            'otherIncomes',
            'incomes',
            'start',
            'end',
            'otherExpenses',
            'totalDuration',
            'expenses',
            'project',
            'datas',
            'stakeholders',
            'supplierDetails'
        ));
    }

    public function progressReport()
    {
        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $projects = Project::where('status', 1)->get();
        } else {
            $projects = Project::where('id', Auth::user()->project_id)->where('status', 1)->get();
        }

        return view('report.progress_report', compact('projects'));
    }

    //    public function bankStatement(Request $request) {
    //        //dd($request->all());
    //
    //        $segments = ProductSegment::where('project_id', Auth::user()->project_id)
    //            ->where('status',1)
    //            ->get();
    //
    //        if(Auth::user()->role == 3 && Auth::user()->admin_status == 1){
    //            $banks = Bank::where('status', 1)->orderBy('name')->get();
    //        }else{
    //            $banks = Bank::where('project_id',Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
    //        }
    //        $result = null;
    //        $metaData = null;
    //        if ($request->bank && $request->branch && $request->account && $request->start && $request->end) {
    //            $bankAccount = BankAccount::where('id', $request->account)->first();
    //            $bank = Bank::where('id', $request->bank)->first();
    //            $branch = Branch::where('id', $request->branch)->first();
    //
    //            $metaData = [
    //                'name' => $bank->name,
    //                'branch' => $branch->name,
    //                'account' => $bankAccount->account_no,
    //                'start_date' => $request->start,
    //                'end_date' => $request->end,
    //            ];
    //
    //            $result = collect();
    //
    //            $initialBalance = $bankAccount->opening_balance;
    //
    //            $previousDay = date('Y-m-d', strtotime('-1 day', strtotime($request->start)));
    //
    //            $totalIncome = TransactionLog::where('transaction_type', 1)
    //                ->where('bank_account_id', $request->account)
    //                ->whereDate('date', '<=', $previousDay)
    //                ->where('product_segment_id', $request->segment)
    //                ->sum('amount');
    //
    //            $totalExpense = TransactionLog::where('transaction_type', 2)
    //                ->where('bank_account_id', $request->account)
    //                ->whereDate('date', '<=', $previousDay)
    //                ->where('product_segment_id', $request->segment)
    //                ->sum('amount');
    //
    //            $openingBalance = $initialBalance + $totalIncome - $totalExpense;
    //
    //            $result->push(['date' => $request->start_date, 'particular' => 'Opening Balance', 'debit' => '', 'credit' => '', 'balance' => $openingBalance]);
    //
    //            $transactionLogs = TransactionLog::where('bank_account_id', $request->account)
    //                ->whereBetween('date', [$request->start, $request->end])
    //                ->where('product_segment_id', $request->segment)
    //                ->get();
    //
    //            $balance = $openingBalance;
    //            $totalDebit = 0;
    //            $totalCredit = 0;
    //            foreach ($transactionLogs as $log) {
    //                if ($log->transaction_type == 1) {
    //                    // Income
    //                    $balance += $log->amount;
    //                    $totalDebit += $log->amount;
    //                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => $log->amount, 'credit' => '', 'balance' => $balance]);
    //                } else {
    //                    $balance -= $log->amount;
    //                    $totalCredit += $log->amount;
    //                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => '', 'credit' => $log->amount, 'balance' => $balance]);
    //                }
    //            }
    //
    //            $metaData['total_debit'] = $totalDebit;
    //            $metaData['total_credit'] = $totalCredit;
    //
    //        }
    //        return view('report.bank_statement', compact('banks', 'result', 'metaData', 'segments'));
    //    }

    public function bankStatement(Request $request)
    {
        $segments = ProductSegment::where('project_id', Auth::user()->project_id)
            ->where('status', 1)
            ->get();

        if (Auth::user()->role == 3 && Auth::user()->admin_status == 1) {
            $banks = Bank::where('status', 1)->orderBy('name')->get();
        } else {
            $banks = Bank::where('project_id', Auth::user()->project_id)->where('status', 1)->orderBy('name')->get();
        }

        $result = null;
        $metaData = null;
        if ($request->bank && $request->branch && $request->account) {
            $bankAccount = BankAccount::where('id', $request->account)->first();
            $bank = Bank::where('id', $request->bank)->first();
            $branch = Branch::where('id', $request->branch)->first();

            $metaData = [
                'name' => $bank->name,
                'branch' => $branch->name,
                'account' => $bankAccount->account_no,
            ];

            $result = collect();

            $initialBalance = $bankAccount->opening_balance;

            $totalIncome = TransactionLog::where('transaction_type', 1)
                ->where('bank_account_id', $request->account)
                ->where('product_segment_id', $request->segment)
                ->sum('amount');

            $totalExpense = TransactionLog::where('transaction_type', 2)
                ->where('bank_account_id', $request->account)
                ->where('product_segment_id', $request->segment)
                ->sum('amount');

            $openingBalance = $initialBalance + $totalIncome - $totalExpense;

            $result->push(['particular' => 'Opening Balance', 'debit' => '', 'credit' => '', 'balance' => $openingBalance]);

            // Check Segment Wise data
            if ($request->segment != 0) {
                $transactionLogs = TransactionLog::where('bank_account_id', $request->account)
                    ->where('product_segment_id', $request->segment)
                    ->get();
            } else {
                $transactionLogs = TransactionLog::where('bank_account_id', $request->account)
                    ->get();
            }


            $balance = $openingBalance;
            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($transactionLogs as $log) {
                if ($log->transaction_type == 1) {
                    // Income
                    $balance += $log->amount;
                    $totalDebit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => $log->amount, 'credit' => '', 'balance' => $balance]);
                } else {
                    $balance -= $log->amount;
                    $totalCredit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => '', 'credit' => $log->amount, 'balance' => $balance]);
                }
            }

            $metaData['total_debit'] = $totalDebit;
            $metaData['total_credit'] = $totalCredit;
        }

        return view('report.bank_statement', compact('banks', 'result', 'metaData', 'segments'));
    }


    public function cashStatementOld(Request $request)
    {
        //dd($request->segment);
        $segments = ProductSegment::where('project_id', Auth::user()->project_id)
            ->where('status', 1)
            ->get();

        $result = null;
        $metaData = null;
        if ($request->start && $request->end) {
            $cashAccount = Cash::first();

            $metaData = [
                'start_date' => $request->start,
                'end_date' => $request->end,
            ];

            $result = collect();

            $initialBalance = $cashAccount->opening_balance;

            $previousDay = date('Y-m-d', strtotime('-1 day', strtotime($request->start)));

            if (Auth::user()->company_branch_id == 0) {

                $totalIncome = TransactionLog::where('transaction_type', 1)
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');
                //dd($totalIncome);

                $totalExpense = TransactionLog::where('transaction_type', 2)
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');
                //dd($totalExpense);
            } else {
                $totalIncome = TransactionLog::where('transaction_type', 1)
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->where('company_branch_id', Auth::user()->company_branch_id)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');
                //dd($totalIncome);

                $totalExpense = TransactionLog::where('transaction_type', 2)
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->where('company_branch_id', Auth::user()->company_branch_id)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');
                //dd($totalExpense);
            }

            $openingBalance = $initialBalance + $totalIncome - $totalExpense;

            $result->push(['date' => $request->start_date, 'particular' => 'Opening Balance', 'debit' => '', 'credit' => '', 'balance' => $openingBalance]);

            if (Auth::user()->company_branch_id == 0) {
                $transactionLogs = TransactionLog::whereBetween('date', [$request->start, $request->end])
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->get();
                //dd($transactionLogs, 'hi1');
            } else {
                $transactionLogs = TransactionLog::whereBetween('date', [$request->start, $request->end])
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->where('company_branch_id', Auth::user()->company_branch_id)
                    ->get();
                //dd($transactionLogs, 'hi2');
            }

            $balance = $openingBalance;
            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($transactionLogs as $log) {
                if ($log->transaction_type == 1) {
                    // Income
                    $balance += $log->amount;
                    $totalDebit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => $log->amount, 'credit' => '', 'balance' => $balance]);
                } else {
                    $balance -= $log->amount;
                    $totalCredit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => '', 'credit' => $log->amount, 'balance' => $balance]);
                }
            }

            $metaData['total_debit'] = $totalDebit;
            $metaData['total_credit'] = $totalCredit;
        }

        return view('report.cash_statement', compact('result', 'metaData', 'segments'));
    }

    public function cashStatement(Request $request)
    {
        //dd(Auth::user()->project_id);
        $segments = ProductSegment::where('project_id', Auth::user()->project_id)
            ->where('status', 1)
            ->get();

        $result = null;
        $metaData = null;
        if ($request->start && $request->end) {
            $start_date = date("Y-m-d", strtotime($request->start));
            $end_date = date("Y-m-d", strtotime($request->end));
            $cashAccount = Cash::first();

            $metaData = [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];

            $result = collect();

            $initialBalance = $cashAccount->opening_balance;

            $previousDay = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));

            if ($request->segment != 0) {
                $totalIncome = TransactionLog::where('transaction_type', 1)

                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');

                $totalExpense = TransactionLog::where('transaction_type', 2)
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');
            } else {
                $totalIncome = TransactionLog::where('transaction_type', 1)
                    ->where('transaction_method', 1)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');

                $totalExpense = TransactionLog::where('transaction_type', 2)
                    ->where('transaction_method', 1)
                    ->whereDate('date', '<=', $previousDay)
                    ->orderBy('date')
                    ->sum('amount');
            }


            $openingBalance = $initialBalance + $totalIncome - $totalExpense;

            $result->push(['date' => $start_date, 'particular' => 'Opening Balance', 'debit' => '', 'credit' => '', 'balance' => $openingBalance]);

            if ($request->segment != 0) {
                $transactionLogs = TransactionLog::whereBetween('date', [$start_date, $end_date])
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->get();
            } else {
                $transactionLogs = TransactionLog::whereBetween('date', [$start_date, $end_date])
                    ->where('transaction_method', 1)
                    ->get();
            }

            $balance = $openingBalance;
            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($transactionLogs as $log) {
                if ($log->transaction_type == 1) {
                    // Income
                    $balance += $log->amount;
                    $totalDebit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => $log->amount, 'credit' => '', 'balance' => $balance]);
                } else {
                    $balance -= $log->amount;
                    $totalCredit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => '', 'credit' => $log->amount, 'balance' => $balance]);
                }
            }

            $metaData['total_debit'] = $totalDebit;
            $metaData['total_credit'] = $totalCredit;
        } else {
            $cashAccount = Cash::first();

            $result = collect();

            $initialBalance = $cashAccount->opening_balance;

            if ($request->segment != 0) {
                $totalIncome = TransactionLog::where('transaction_type', 1)
                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->orderBy('date')
                    ->sum('amount');

                $totalExpense = TransactionLog::where('transaction_type', 2)

                    ->where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->orderBy('date')
                    ->sum('amount');
            } else {
                $totalIncome = TransactionLog::where('transaction_type', 1)

                    ->where('transaction_method', 1)
                    ->orderBy('date')
                    ->sum('amount');

                $totalExpense = TransactionLog::where('transaction_type', 2)

                    ->where('transaction_method', 1)
                    ->orderBy('date')
                    ->sum('amount');
            }

            $openingBalance = $initialBalance + $totalIncome - $totalExpense;

            $result->push(['particular' => 'Opening Balance', 'debit' => '', 'credit' => '', 'balance' => $openingBalance]);


            if ($request->segment != 0) {
                $transactionLogs = TransactionLog::where('product_segment_id', $request->segment)
                    ->where('transaction_method', 1)
                    ->get();
            } else {
                $transactionLogs = TransactionLog::where('project_id', Auth::user()->project_id)
                    ->get();
            }

            $balance = $openingBalance;
            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($transactionLogs as $log) {
                if ($log->transaction_type == 1) {
                    // Income
                    $balance += $log->amount;
                    $totalDebit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => $log->amount, 'credit' => '', 'balance' => $balance]);
                } else {
                    $balance -= $log->amount;
                    $totalCredit += $log->amount;
                    $result->push(['date' => $log->date, 'particular' => $log->particular, 'debit' => '', 'credit' => $log->amount, 'balance' => $balance]);
                }
            }

            $metaData['total_debit'] = $totalDebit;
            $metaData['total_credit'] = $totalCredit;
        }
        //ddd($result);
        return view('report.cash_statement', compact('result', 'metaData', 'segments'));
    }

    //    public function allReceivePayment(Request $request) {
    //        $segments = ProductSegment::where('project_id',Auth::user()->project_id)
    //                ->where('status',1)
    //                ->get();
    //        $incomes = null;
    //        $expenses = null;
    //
    //
    //        if ($request->start && $request->end && $request->segment != 0) {
    //            $incomes = TransactionLog::whereIn('transaction_type', [1])
    //                ->where('project_id',Auth::user()->project_id)
    //                ->whereIn('product_segment_id',[$request->segment])
    //                ->with('transaction')
    //                ->whereBetween('date', [$request->start, $request->end])
    //                ->get();
    //
    //            $expenses = TransactionLog::whereIn('transaction_type', [2])
    //                ->where('project_id',Auth::user()->project_id)
    //                ->whereIn('product_segment_id',[$request->segment])
    //                ->with('transaction')
    //                ->whereBetween('date', [$request->start, $request->end])
    //                ->get();
    //
    //        }else if($request->start && $request->end ){
    //            $incomes = TransactionLog::whereIn('transaction_type', [1])
    //                ->where('project_id',Auth::user()->project_id)
    //                ->with('transaction')
    //                ->whereBetween('date', [$request->start, $request->end])
    //                ->get();
    //            $expenses = TransactionLog::whereIn('transaction_type', [2])
    //                ->where('project_id',Auth::user()->project_id)
    //                ->with('transaction')
    //                ->whereBetween('date', [$request->start, $request->end])
    //                ->get();
    //        }
    //
    //        return view('report.all_receive_payment', compact('incomes', 'expenses','segments'));
    //    }

    public function allReceivePayment(Request $request)
    {
        $start_date = $request->start ? date("Y-m-d", strtotime($request->start)) : null;
        $end_date = $request->end ? date("Y-m-d", strtotime($request->end)) : null;

        $segments = ProductSegment::where('project_id', Auth::user()->project_id)
            ->where('status', 1)
            ->get();

        $incomes = TransactionLog::whereIn('transaction_type', [1])
            ->where('project_id', Auth::user()->project_id)
            ->with('transaction');

        $expenses = TransactionLog::whereIn('transaction_type', [2])
            ->where('project_id', Auth::user()->project_id)
            ->with('transaction');

        if ($request->segment != 0) {
            $incomes->whereIn('product_segment_id', [$request->segment]);
            $expenses->whereIn('product_segment_id', [$request->segment]);
        }

        if ($start_date && $end_date) {
            $incomes->whereBetween('date', [$start_date, $end_date]);
            $expenses->whereBetween('date', [$start_date, $end_date]);
        }

        $incomes = $incomes->get();
        $expenses = $expenses->get();

        if ($request->has('all')) {
            $incomes = [];
            $expenses = [];
        }

        return view('report.all_receive_payment', compact('incomes', 'expenses', 'segments'));
    }
}
