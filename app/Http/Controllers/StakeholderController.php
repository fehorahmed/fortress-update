<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Cash;
use App\Models\ProductSegment;
use App\Models\Project;
use App\Models\ProjectWiseStakeholder;
use App\Models\Stakeholder;
use App\Models\StakeholderPayment;
use App\Models\TransactionLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use SakibRahaman\DecimalToWords\DecimalToWords;
use Yajra\DataTables\Facades\DataTables;

class StakeholderController extends Controller
{
    public function showProjects() {
        $projects = Project::where('id', Auth::user()->project_id)->where('status', 1)->get();
        return view('stakeholder.projects', compact('projects'));
    }

    public function index(Project $project) {
        $stakeholders = ProjectWiseStakeholder::where('project_id', Auth::user()->project_id)->get();
        return view('stakeholder.all', compact('stakeholders', 'project'));
    }

    public function add() {
        //$projects = Project::where('id', Auth::user()->project_id)->get();
        $stakeholders = Stakeholder::where('project_id', Auth::user()->project_id)->get();
        return view('stakeholder.add', compact( 'stakeholders'));
    }

    public function addPost(Request $request) {
        $rules = [
            //  'id_no' => 'required|unique:stakeholders,id_no',
            //'project' => 'required',
        ];

        //dd($request->all());

        if ($request->stakeholder_type == 1) {
            $rules['stakeholder_id'] = [
                'required', 'max:255',
                Rule::unique('project_wise_stakeholders')
                    ->where('project_id', Auth::user()->project_id)
            ];

        } else {
            $rules['name'] = 'required|string|max:255';
            $rules['father_name'] = 'nullable|string|max:255';
            $rules['address'] = 'nullable|string|max:255';
            $rules['nid'] = 'nullable|string|max:255|unique:stakeholders';
            $rules['mobile_no'] = 'required|string|max:255';
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['username'] = 'nullable|string|max:255|min:5|unique:users';
            $rules['password'] = 'required|string|max:255|min:8|confirmed';
        }
        $messsages = array(
            'stakeholder_id.unique' => 'This Stakeholder Already in This Project.',
        );

        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->stakeholder_type == 2) { //new Stakeholder
            $stakeholder = new Stakeholder();
            $stakeholder->name = $request->name;
            $stakeholder->project_id = Auth::user()->project_id;
            $stakeholder->address = $request->address;
            $stakeholder->nid = $request->nid;
            $stakeholder->user_id = Auth::id();
            $stakeholder->father_name = $request->father_name;
            $stakeholder->mobile_no = $request->mobile_no;
            $stakeholder->save();
            $stakeholder->id_no = 10000 + $stakeholder->id;
            $stakeholder->save();

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->project_id = Auth::user()->project_id;
            $user->user_id = Auth::id();
            $user->email = $request->email;
            $user->role = 1;
            $user->stakeholder_id = $stakeholder->id;
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $projectWiseStakeholder = new ProjectWiseStakeholder();
        $projectWiseStakeholder->project_id =  Auth::user()->project_id;
        $projectWiseStakeholder->user_id = Auth::id();
        if ($request->stakeholder_type == 1) {
            $projectWiseStakeholder->stakeholder_id = $request->stakeholder_id;
        } else {
            $projectWiseStakeholder->stakeholder_id = $stakeholder->id;
        }
        $projectWiseStakeholder->save();


        return redirect()->route('stakeholder.projects')->with('message', 'Stakeholder add successfully.');
    }

    public function edit(Stakeholder $stakeholder)
    {
        $user = User::where('project_id', Auth::user()->project_id)->where('stakeholder_id', $stakeholder->id)->first();
        // dd($user);
        $projects = Project::where('id', Auth::user()->project_id)->where('status', 1)->get();
        return view('stakeholder.edit', compact('stakeholder', 'projects', 'user'));
    }

    public function editPost(Stakeholder $stakeholder, Request $request)
    {
        $request->validate([
            //'project' => 'required',
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:255|unique:stakeholders,nid,' . $stakeholder->id,
            'mobile_no' => 'required|string|max:255',
        ]);
        $user = User::where('stakeholder_id', $stakeholder->id)
            ->where('project_id', $stakeholder->project_id)->first();
        //$user->project_id = Auth::user()->project_id;
        $user->project_id = $stakeholder->project_id;
        $user->save();

        //$stakeholder->project_id = $stakeholder->project_id;
        $stakeholder->name = $request->name;
        $stakeholder->father_name = $request->father_name;
        $stakeholder->address = $request->address;
        $stakeholder->nid = $request->nid;
        $stakeholder->mobile_no = $request->mobile_no;
        $stakeholder->save();

        return redirect()->route('stakeholder.all',['project' => $stakeholder->project_id])->with('message', 'Stakeholder edit successfully.');
    }

    public function datatable()
    {
        $query = Stakeholder::where('project_id', Auth::user()->project_id);

        return DataTables::eloquent($query)
            ->addColumn('action', function (Stakeholder $stakeholder) {
                return '<a class="btn btn-info btn-sm" href="' . route('stakeholder.edit', ['stakeholder' => $stakeholder->id]) . '">Edit</a>';
            })
            ->addColumn('project', function (Stakeholder $stakeholder) {

                return $stakeholder->project->name;
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }

    public function stakeholderPayment() {
        $projects = Project::where('id', Auth::user()->project_id)->where('status', 1)->get();
        $bankAccounts = BankAccount::where('project_id', Auth::user()->project_id)->where('status', 1)->get();
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)
            ->where('status',1)
            ->get();
        // $stackholders = Stakeholder::where('project_id', Auth::user()->project_id)->get();
        // dd($stackholders);
        $stackholders = ProjectWiseStakeholder::where('project_id', Auth::user()->project_id)->get();
        // dd($stackholders);
        return view('stakeholder.payment_add', compact('bankAccounts','segments','stackholders'));
    }

    public function stakeholderPaymentDatatable()
    {
        $query = Stakeholder::where('project_id', Auth::user()->project_id);
        // dd($query);
        return DataTables::eloquent($query)
            ->addColumn('action', function (Stakeholder $stakeholder) {
                if ($stakeholder->due > 0) {
                    $btns = '<a class="btn btn-info btn-sm btn-pay" role="button" data-due="' . $stakeholder->due . '" data-id="' . $stakeholder->id . '" data-name="' . $stakeholder->name . '">Receive</a>
                <a href="' . route('payment_details_by_stakeholder', ['stakeholder' => $stakeholder->id]) . '"  class="btn btn-primary btn-sm btn-details" >Details</a>';
                    return $btns;
                } else {
                    $btns = ' <a href="' . route('payment_details_by_stakeholder', ['stakeholder' => $stakeholder->id]) . '"  class="btn btn-primary btn-sm btn-details" >Details</a>';
                    return $btns;
                }
            })
            ->addColumn('paid', function (Stakeholder $stakeholder) {
                $paid_cal = number_format($stakeholder->paid  ?? 0, 2);
                return $paid_cal;
            })
            ->addColumn('due', function (Stakeholder $stakeholder) {
                 if($stakeholder->total > $stakeholder->paid){
                    $due_val =  $stakeholder->total - $stakeholder->paid;
                    return number_format($due_val ?? 0, 2);
                 }else{
                     $due_val =  $stakeholder->total - $stakeholder->paid;
                     return number_format($due_val ?? 0, 2);
                 }
            })
            ->addColumn('total', function (Stakeholder $stakeholder) {
                $total_cal = number_format($stakeholder->total ?? 0, 2);
                return $total_cal;
            })
            ->addColumn('advance', function (Stakeholder $stakeholder) {
                if($stakeholder->paid > $stakeholder->total){
                    $advance = $stakeholder->paid - $stakeholder->total;
                    return number_format($advance, 2);
                }
                return number_format(0, 2);
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function stakeholderPaymentGetProjects(Request $request)
    {
        $orders = ProjectWiseStakeholder::with('project')
            ->where('stakeholder_id', $request->stakeholderId)
            ->where('project_id', Auth::user()->project_id)
            // ->where('budget_due', '>', 0)
            //  ->where('profit_due', '>', 0)
            ->orderBy('project_id')
            ->get()->toArray();

        return response()->json($orders);
    }

    public function getProjectWiseStakeholderDetails(Request $request) {
        $project = ProjectWiseStakeholder::where('stakeholder_id', $request->stakeholderId)->first()->toArray();
            //->where('project_id', Auth::user()->project_id)
            //->where('project_id', $request->projectId);

        return response()->json($project);
    }

    public function stakeholderMakePayment(Request $request)
    {
        $rules = [
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            // 'next_payment_date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ];

        if ($request->payment_type == '2') {
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->account != '') {
            $account = BankAccount::find($request->account);
        }
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $projectWise = ProjectWiseStakeholder::where('stakeholder_id',$request->stakeholder_id)
            ->where('project_id', Auth::user()->project_id)->first();

        $stakePayment = new StakeholderPayment();
        $stakePayment->stakeholder_id = $request->stakeholder_id;
        $stakePayment->project_id = Auth::user()->project_id;
        $stakePayment->product_segment_id = $request->segment;
        $stakePayment->project_wise_stakeholder_id = $projectWise->id;
        $stakePayment->received_type = 1; //1=nogod, 2=due
        $stakePayment->type = 1; //1=payment
        $stakePayment->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $stakePayment->bank_id = $account->bank_id;
            $stakePayment->branch_id = $account->branch_id;
            $stakePayment->bank_account_id = $account->id;
            $stakePayment->cheque_no = $request->cheque_no;
            $image = '';

            if ($request->cheque_image) {
                // Upload Image
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/stakeholder_payment_cheque';
                $file->move($destinationPath, $filename);

                $image = 'uploads/stakeholder_payment_cheque/' . $filename;
            }
            $stakePayment->cheque_image = $image;
        }

        $stakePayment->total = $request->amount; //Total
        $stakePayment->paid = $request->amount;
        if ($request->amount > $request->total_due){
            $projectWise->advance_amount = $request->amount - $request->total_due;
            $projectWise->decrement('budget_due', $projectWise->budget_due);
        }else{
            $projectWise->decrement('budget_due', $request->amount);
        }
        $projectWise->increment('budget_paid', $request->amount);
        $stakePayment->date = $date;
        $stakePayment->next_payment_date = $request->next_payment_date;
        $stakePayment->note = $request->note;
        $stakePayment->user_id = Auth::id();
        $stakePayment->save();
        $stakePayment->payment_id = 10000 + $stakePayment->id;
        $stakePayment->save();

        $log = new TransactionLog();
        $log->particular = 'Receive from ' . $projectWise->stakeholder->name . ' for instalment' . $stakePayment->payment_id;
//        $log->date = date('Y-m-d');
        $log->date = $date;
        $log->next_payment_date = $request->next_payment_date;
        $log->stakeholder_payment_id = $stakePayment->id;
        $log->project_id = Auth::user()->project_id;
        $log->product_segment_id = $request->segment;
        $log->stakeholder_id = $request->stakeholder_id;
        $log->project_wise_stakeholder_id = $projectWise->id;
        $log->transaction_type = 1; //1=Income; 2=Expense;
        $log->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
        }
        $log->account_head_type_id = 2;
        $log->account_head_sub_type_id = 2;
        $log->amount = $request->amount;
        $log->note = $request->note;
        $log->user_id = Auth::id();
        $log->instalment_no = $stakePayment->instalment_no;
        $log->save();
        $stakePayment->transaction_log_id = $log->id;
        $stakePayment->save();

        $projectWise->save();

        if ($request->payment_type == 2) {
            $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id', $request->account)->first();
            $bankAccount->increment('balance', $request->amount);
        } elseif ($request->payment_type == 1) {
            Cash::where('project_id',Auth::user()->project_id)->increment('amount', $request->amount);
        }

        return response()->json(['success' => true, 'message' => 'Stakeholder Payment has been completed.',
            'redirect_url' => route('stakeholder.payment_receipt', ['payment' => $stakePayment->id])]);
    }

    public function paymentDetailsByStakeholder(Stakeholder $stakeholder)
    {
        $payments = StakeholderPayment::where('stakeholder_id', $stakeholder->id)->get();
        return view('stakeholder.payments', compact('payments','stakeholder'));
    }
    public function paymentDetailsEdit(StakeholderPayment $stakeholderPayment){
        // dd($stakeholderPayment);
        $segments = ProductSegment::where('project_id',Auth::user()->project_id)
            ->where('status',1)->orderBy('name')->get();
        $bankAccounts = BankAccount::where('project_id',Auth::user()->project_id)->get();
        return view('stakeholder.payment_edit',
            compact('stakeholderPayment','segments','bankAccounts'));
    }
    public function paymentDetailsEditPost(Request $request, StakeholderPayment $stakeholderPayment){
        // dd($stakeholderPayment->id);
        $totalAmount =  $request->stakeholder_due + $stakeholderPayment->paid;

        if ($request->amount > $totalAmount){
            $rules = [
                'payment_type' => 'required',
                'amount' => 'required|numeric|min:0|max:'.$totalAmount,
                //'next_payment_date' => 'required|date',
                'note' => 'nullable|string|max:255',
            ];
        }else{
            $rules = [
                'payment_type' => 'required',
                'amount' => 'required|numeric|min:0',
                'note' => 'nullable|string|max:255',
            ];
        }

        if ($request->payment_type == '2') {
            $rules['account'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->account != '') {
            $account = BankAccount::find($request->account);
        }

        $projectWise = ProjectWiseStakeholder::where('stakeholder_id',$stakeholderPayment->stakeholder_id)
            ->where('project_id', Auth::user()->project_id)->first();
        $projectWise->increment('budget_due', $stakeholderPayment->paid);
        $projectWise->decrement('budget_paid', $stakeholderPayment->paid);

        if ($stakeholderPayment->transaction_method == 2) {
            $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id', $request->account)->first();
            $bankAccount->decrement('balance', $stakeholderPayment->paid);
        } elseif ($stakeholderPayment->transaction_method == 1) {
            Cash::where('project_id',Auth::user()->project_id)
                ->decrement('amount', $stakeholderPayment->paid);
        }
        // TransactionLog::where('stakeholder_payment_id',$stakeholderPayment->id)->delete();
        // $stakeholderPayment->delete();

        $stakePayment = StakeholderPayment::find($stakeholderPayment->id);
        $stakePayment->stakeholder_id = $stakeholderPayment->stakeholder_id;
        $stakePayment->project_id = Auth::user()->project_id;
        $stakePayment->product_segment_id = $request->segment;
        $stakePayment->project_wise_stakeholder_id = $projectWise->id;
        $stakePayment->received_type = 1; //1=nogod, 2=due
        $stakePayment->type = 1; //1=payment
        $stakePayment->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $stakePayment->bank_id = $account->bank_id;
            $stakePayment->branch_id = $account->branch_id;
            $stakePayment->bank_account_id = $account->id;
            $stakePayment->cheque_no = $request->cheque_no;
            $image = '';

            if ($request->cheque_image) {
                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->getClientOriginalExtension();
                $destinationPath = 'public/uploads/stakeholder_payment_cheque';
                $file->move($destinationPath, $filename);

                $image = 'uploads/stakeholder_payment_cheque/' . $filename;
            }
            $stakePayment->cheque_image = $image;
        }

        $stakePayment->total = $request->amount; //Total
        $stakePayment->paid = $request->amount;

        $projectWise->decrement('budget_due', $request->amount);
        $projectWise->increment('budget_paid', $request->amount);

        $stakePayment->date = $request->date;
        // dd($stakePayment->date);
        $stakePayment->next_payment_date = $request->next_payment_date;
        $stakePayment->note = $request->note;
        $stakePayment->user_id = Auth::id();
        $stakePayment->save();
        $stakePayment->payment_id = 10000 + $stakePayment->id;
        $stakePayment->save();

        $log = new TransactionLog();
        $log->particular = 'Receive from ' . $projectWise->stakeholder->name . ' for instalment' . $stakePayment->payment_id;
        $log->date = date('Y-m-d');
        $log->next_payment_date = $request->next_payment_date;
        $log->stakeholder_payment_id = $stakePayment->id;
        $log->project_id = Auth::user()->project_id;
        $log->product_segment_id = $request->segment;
        $log->stakeholder_id = $stakeholderPayment->stakeholder_id;
        $log->project_wise_stakeholder_id = $projectWise->id;
        $log->transaction_type = 1; //1=Income; 2=Expense;
        $log->transaction_method = $request->payment_type;
        if ($request->payment_type == 2) {
            $log->bank_id = $account->bank_id;
            $log->branch_id = $account->branch_id;
            $log->bank_account_id = $account->id;
            $log->cheque_no = $request->cheque_no;
            $log->cheque_image = $image;
        }
        $log->account_head_type_id = 2;
        $log->account_head_sub_type_id = 2;
        $log->amount = $request->amount;
        $log->note = $request->note;
        $log->user_id = Auth::id();
        $log->instalment_no = $stakePayment->instalment_no;
        $log->save();
        $stakePayment->transaction_log_id = $log->id;
        $stakePayment->save();

        $projectWise->save();

        if ($request->payment_type == 2) {
            $bankAccount = BankAccount::where('project_id',Auth::user()->project_id)
                ->where('id', $request->account)->first();
            $bankAccount->increment('balance', $request->amount);
        } elseif ($request->payment_type == 1) {
            Cash::where('project_id',Auth::user()->project_id)->increment('amount', $request->amount);
        }

       // dd($projectWise);

        return redirect()->route('stakeholder.payment_receipt',['payment' => $stakePayment->id])
            ->with('message', 'Stakeholder Payment Edit has been completed.');

    }

    public function paymentDetailsPrint(Stakeholder $stakeholder){
        $payments = StakeholderPayment::where('stakeholder_id', $stakeholder->id)->get();
        return view('stakeholder.payment_details_print', compact('payments','stakeholder'));
    }

    public function paymentReceipt(StakeholderPayment $payment)
    {
        $payment->amount_in_word = DecimalToWords::convert($payment->total, 'Taka', 'Poisa');
        $date = Carbon::createFromFormat('Y-m-d', $payment->date)->format('d-m-Y');
        return view('stakeholder.payment_receipt', compact('payment','date'));
    }

}
