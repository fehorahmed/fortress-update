<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Cash;
use App\Models\Project;
use App\Models\ProjectWiseStakeholder;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {

        return view('administrator.project.all');
    }

    public function add()
    {

        return view('administrator.project.add');
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:projects',
            'opening_balance' => 'required|numeric|min:0',
            'address' => 'nullable|max:255',
            'status' => 'required'
        ]);

        $project = new Project();
        $project->name = $request->name;
        $project->address = $request->address;
        $project->status = $request->status;
        $project->user_id = Auth::id();
        $project->save();

        $cash = new Cash();
        $cash->project_id = Auth::user()->project_id;
        $cash->amount = $request->opening_balance;
        $cash->opening_balance = $request->opening_balance;
        $cash->save();

        return redirect()->route('project.all')->with('message', 'Project add successfully.');
    }

    public function edit(Project $project)
    {
        return view('administrator.project.edit', compact('project'));
    }

    public function editPost(Project $project, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:projects,name,' . $project->id,
            'opening_balance' => 'required|numeric|min:0',
            'address' => 'nullable|max:255',
            'status' => 'required'
        ]);

        $project->name = $request->name;
        $project->address = $request->address;
        $project->status = $request->status;
        $project->save();

        $cash = Cash::where('project_id',$project->id)->first();
        if ($cash) {
            $old_amount = $request->opening_balance - $cash->opening_balance;
            $cash->opening_balance = $request->opening_balance;
            $cash->amount = $cash->amount + $old_amount;
            $cash->save();
        }else{
            $newCash = new Cash();
            $newCash->project_id = $project->id;
            $newCash->amount = $request->opening_balance;
            $newCash->opening_balance = $request->opening_balance;
            $newCash->save();
        }

        return redirect()->route('project.all')->with('message', 'Project edit successfully.');
    }

    public function datatable()
    {
        $query = Project::with('cash');

        return DataTables::eloquent($query)
            ->addColumn('action', function (Project $project) {
                return '<a class="btn btn-info btn-sm" href="' . route('project.edit', ['project' => $project->id]) . '">Edit</a>';
            })
            ->editColumn('opening_balance', function (Project $project) {
                return $project->cash->opening_balance??'0';
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

    public function duration()
    {
        $budgets = Budget::where('project_id', Auth::user()->project_id)->where('status', 1)->get();
        return view('administrator.project.duration.all', compact('budgets'));
    }

    public function budgetAdd(){
        return view('administrator.project.duration.add');
    }

    public function budgetAddPost(Request $request){
        $request->validate([
            'budget' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        
        $max_budget_no = Budget::where('project_id', Auth::user()->project_id)->max('budget_no');
        $new_budget_no = intval($max_budget_no)+1;

        $budget = new Budget();
        $budget->project_id = Auth::user()->project_id;
        $budget->budget = $request->budget;
        $budget->status = $request->status;
        $budget->save();
        $budget->budget_no = str_pad($new_budget_no, 6, 0, STR_PAD_LEFT);
        $budget->save();

        return redirect()->route('duration')->with('message', 'Project Budget Add successfully.');
    }

    public function durationEdit(Budget $budget)
    {
        return view('administrator.project.duration.edit', compact('budget'));
    }

    public function durationEditPost(Budget $budget, Request $request)
    {

        $request->validate([
            //'duration_start' => 'date|nullable',
            //'duration_end' => 'date|nullable',
            //'total' => 'required|numeric|min:1',
            'budget' => 'required|numeric|min:1',
            'status' => 'required',
        ]);

        //$budget->project_id = Auth::user()->project_id;
        //$project->duration_end = $request->duration_end;
        $budget->budget = $request->budget;
        //$project->total_duration = $request->total;
        $budget->status = $request->status;
        $budget->save();

        return redirect()->route('duration')->with('message', 'Project Budget Update successfully.');
    }

//budget

    public function installment()
    {

        $projects = Project::where('id',Auth::user()->project_id)->where('status', 1)->orderBy('id','desc')->get();

        return view('administrator.project.budget.all', compact('projects'));
    }


    public function installmentEdit(Project $project)
    {
        return view('administrator.project.budget.edit', compact('project'));
    }

    public function installmentEditPost(Project $project, Request $request)
    {
        $request->validate([
            'installment' => 'numeric|required',
        ]);

        $project->total_installment = $request->installment;
        $project->save();

        return redirect()->route('project.installment')->with('message', 'Project Installment Update successfully.');
    }


    public function budgetDistribute(Request $request) {
        //dd($request->all());
        $budgets = Budget::where('project_id',Auth::user()->project_id)
            ->where('distribution_status', 1)
            ->where('status', 1)
            ->orderBy('budget_no')
            ->get();
        $budget = Budget::where('id', $request->budget)->first();
        $stakeholders = ProjectWiseStakeholder::where('project_id', Auth::user()->project_id)->get();

        if ($request->submit) {
            $request->validate([
                'budget' => 'required',
            ]);
            $budget = Budget::where('id', $request->budget)->first();
            $stakeholders = ProjectWiseStakeholder::where('project_id', $budget->project_id)->get();
            $totalStakeholder = count($stakeholders);
            $budgetAmount = $budget->budget;
            $amountPerPerson = ($budgetAmount / $totalStakeholder);

            if ($totalStakeholder > 0) {
                foreach ($stakeholders as $stakeholder) {
                    $projectWise = ProjectWiseStakeholder::where('id', $stakeholder->id)->first();
                    $projectWise->increment('budget_per_instalment_amount',$amountPerPerson);
                    $projectWise->decrement('budget_per_instalment_amount',$projectWise->advance_amount);
                    $projectWise->increment('budget_total',$amountPerPerson);
                    $projectWise->increment('budget_due',$amountPerPerson);
                    $projectWise->decrement('budget_due',$projectWise->advance_amount);
                    $projectWise->save();
                }
                $budget->distribution_status = 2;
                $budget->save();
            } else {
                return redirect()->back()->with('message', 'You Have No Stakeholder.Please First Add  Stakeholder.');
            }
            return redirect()->back()->with('message', 'Budget Amount Updated.');
        }

        return view('administrator.project.budget.budget_distribute', compact('budgets', 'stakeholders', 'budget'));
    }

//    public function profitBudgetDistribute(Request $request)
//    {
//
//        $projects = Project::where('status', 1)->orderBy('name')->get();
//        $stakeholders = [];
//        $profitBudget = [];
//        if ($request->show) {
//            $profitBudget = Project::where('id', $request->project)->first();
//            $stakeholders = ProjectWiseStakeholder::where('project_id', $request->project)->get();
//        }
//        if ($request->submit) {
//            $request->validate([
//                'project' => 'required',
//            ]);
//            $profitBudget = Project::where('id', $request->project)->first();
//            $stakeholders = ProjectWiseStakeholder::where('project_id', $request->project)->get();
//
//            $totalStakeholder = count($stakeholders);
//            $profitAmount = $profitBudget->profit_budget;
//            $totalDuration = $profitBudget->total_duration;
//            if ($totalDuration > 0 && $totalStakeholder > 0) {
//                $amountPerPerson = ($profitAmount / $totalStakeholder);
//                $profitPerInstalmentAmount = $amountPerPerson / $totalDuration;
//
//                foreach ($stakeholders as $stakeholder) {
//                    $stake = Stakeholder::where('id', $stakeholder->stakeholder_id)->first();
//                    $stake->profit_instalment_amount = $profitPerInstalmentAmount;
//                    $stake->profit_instalment = $totalDuration;
//                    $stake->save();
//                    $projectWise = ProjectWiseStakeholder::where('id', $stakeholder->id)->first();
//                    $projectWise->profit_instalment = $totalDuration;
//                    $projectWise->profit_per_instalment_amount = $profitPerInstalmentAmount;
//                    $projectWise->profit_total = $amountPerPerson;
//                    $projectWise->profit_due = $amountPerPerson;
//                    $projectWise->save();
//                }
//                $profitBudget->profit_update_status=1;
//                $profitBudget->save();
//            } else {
//                return redirect()->back()->with('message', 'Project Duration or Stakeholder Error.Please  check.');
//            }
//            return redirect()->back()->with('message', 'Profit Instalment Amount Updated.');
//        }
//
//        return view('administrator.project.profit_budget.profit_budget_distribute', compact('projects', 'stakeholders', 'profitBudget'));
//    }

//    public function projectWiseStakeholder(){
//
//        return view('administrator.project.project_wise_stakeholder');
//    }

}
