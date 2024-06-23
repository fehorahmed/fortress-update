<?php

namespace App\Http\Controllers;

use App\Models\DocumentationInfo;
use App\Models\DocumentationInfoImages;
use App\Models\PhysicalProgress;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\ProjectGallary;
use App\Models\ProjectWiseStakeholder;
use App\Models\PurchasePayment;
use App\Models\Stakeholder;
use App\Models\StakeholderPayment;
use App\Models\TransactionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stackHolderLogin(User $user){

        $user = User::where('id',$user->id)->first();

        if ($user->id != 1) {
            $admin = User::where('id',1)->first();
            $admin->project_id = $user->project_id;
            $admin->stakeholder_id = $user->stakeholder_id;
            $admin->role = $user->role;
            $admin->save();
        }else{
            $admin = User::where('id',1)->first();
            $admin->project_id = null;
            $admin->stakeholder_id = null;
            $admin->role = 0;
            $admin->save();
        }

        return redirect()->back();
    }
    public function index()
    {
        $stakeholderId = Auth::user()->stakeholder_id;
        $projectIds=ProjectWiseStakeholder::where('stakeholder_id',$stakeholderId)->pluck('project_id');

        $progress = PhysicalProgress::whereIn('project_id', $projectIds)->sum('project_progress_percentance');

        $datas = [
            'projects' => count($projectIds),
            'progress' => $progress,

        ];
        return view('stakeholder_view.home', compact('datas'));
    }

    public function gallery()
    {
        $stakeholderId = Auth::user()->stakeholder_id;
        $projectIds=ProjectWiseStakeholder::where('stakeholder_id',$stakeholderId)->pluck('project_id');

        $images = ProjectGallary::whereIn('project_id', $projectIds)->get();

        return view('stakeholder_view.gallery.gallery_view', compact('images'));
    }

    public function documentation()
    {

        $stakeholderId = Auth::user()->stakeholder_id;
        $projectIds=ProjectWiseStakeholder::where('stakeholder_id',$stakeholderId)->pluck('project_id');

        $documentations = DocumentationInfo::whereIn('project_id', $projectIds)->get();

        return view('stakeholder_view.gallery.documentation', compact('documentations'));
    }

    public function documentationDetails(DocumentationInfo $documentation)
    {

        $documentationDetails = DocumentationInfoImages::where('documentation_info_id', $documentation->id)->get();

        return view('stakeholder_view.gallery.documentation_details', compact('documentationDetails', 'documentation'));
    }

    public function payment()
    {

        $stakeholderId = Auth::user()->stakeholder_id;
        $projectIds=ProjectWiseStakeholder::where('stakeholder_id',$stakeholderId)->pluck('project_id');
      // dd($projectIds);
        $projects= Project::whereIn('id',$projectIds)->get();
        $payments = StakeholderPayment::where('stakeholder_id', $stakeholderId)
            ->whereIn('project_id',$projectIds)
            ->get();

        return view('stakeholder_view.payments', compact('payments','projects'));
    }

    public function project(Request $request)
    {

        $stakeholderId = Auth::user()->stakeholder_id;
        $projectIds =ProjectWiseStakeholder::where('stakeholder_id',$stakeholderId)->pluck('project_id');
        $projects = Project::whereIn('id',$projectIds)->get();
        $stakeholders=[];
        $stakePayments=[];
        $incomes=0;
        $expenses=0;
        $datas = [
            'project' => '',
            'budgetTotal' => '',
            'budget_due' => '',
            'start' => '',
            'end' =>'',
            'nextPayment' =>'',
        ];
    if ($request->project && $request->project != ''){
        $project= Project::find($request->project);
        $stakeholderIds= ProjectWiseStakeholder::where('project_id',$request->project)->pluck('stakeholder_id');
        $stakeholders= Stakeholder::whereIn('id',$stakeholderIds)->get();
//        $incomes = TransactionLog::where('project_id', $request->project)->whereNotIn('project_payment_type', [3])->where('transaction_type', 1)->sum('amount');
        $incomes= TransactionLog::where('project_id',$request->project)->where('transaction_type',1)->sum('amount');
        $expenses= TransactionLog::where('project_id',$request->project)->where('transaction_type',2)->sum('amount');
        $budgetTotal= ProjectWiseStakeholder::where('project_id', $request->project)
            ->where('stakeholder_id', $stakeholderId)->first();
        $stakePayments= StakeholderPayment::where('project_id', $request->project)
            ->where('stakeholder_id', $stakeholderId)->get();

        $nextPayment= StakeholderPayment::where('project_id', $request->project)
            ->where('stakeholder_id', $stakeholderId)->orderBy('id','desc')->first();

        //dd($stakeholders);
        $datas = [
            'project' => $project,
            'budgetTotal' => $budgetTotal->budget_total,
            'budget_due' => $budgetTotal->budget_due,
            'start' => $project->duration_start,
            'end' => $project->duration_end,
            'nextPayment' => $nextPayment->next_payment_date,
        ];
    }


        return view('stakeholder_view.project', compact('projects',
        'stakeholders','datas','incomes','expenses','stakePayments'));
    }

    public function projectProgress(Request $request)
    {

        $stakeholderId = Auth::user()->stakeholder_id;
        $projectIds =ProjectWiseStakeholder::where('stakeholder_id',$stakeholderId)->pluck('project_id');
        $projects = Project::whereIn('id',$projectIds)->get();
        $progresses=[];
        $segments=[];
        if($request->project){
         $segments = ProductSegment::where('project_id', $request->project)->get();

         $progresses = PhysicalProgress::where('project_id', $request->project)->get();
        }



        return view('stakeholder_view.progress', compact(
            'projects','segments','progresses'));
    }
}
