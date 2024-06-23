<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $guarded = [];
//    protected $fillable = [
//        'project_id',
//        'name',
//        'father_name',
//        'address',
//        'nid',
//        'mobile_no' ,
//    ];


    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
//    public function getTotalInstallmentAttribute(){
//        return $this->hasMany(StakeholderPayment::class,'stakeholder_id')->sum('instalment_no');
//    }
    public function getDueAttribute() {
        $budget= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('budget_due');
      //  $profit= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('profit_due');
        return $budget;
    }

    public function getPaidAttribute() {
        $budget= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('budget_paid');
        //$extra= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('extra_amount');
        return $budget;
    }

    public function getTotalAttribute() {
        $budget= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('budget_total');
    //    $profit= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('profit_total');
        return $budget;

    }

    public function getAdvanceAttribute() {
        $budget= ProjectWiseStakeholder::where('stakeholder_id', $this->id)->sum('advance_amount');
        return $budget;

    }

//totalBudgetPayment

    public function totalBudgetPaymentAll($project) {
        $totalBudgetPayment= TransactionLog::where('stakeholder_id', $this->id)
            ->where('transaction_type',1)
            ->where('project_id',$project)
            ->where('project_payment_type', 1)->sum('amount');

        return $totalBudgetPayment;
    }

    //TotalBudgetPayment
    public function getTotalBudgetPaymentAttribute() {
        $totalBudgetPayment= TransactionLog::where('stakeholder_id', $this->id)
            ->where('transaction_type',1)
            ->where('project_payment_type',1)->sum('amount');

        return $totalBudgetPayment;
    }

    public function totalPayment($project) {
        $totalBudgetPayment= TransactionLog::where('stakeholder_id', $this->id)
            ->where('project_id',$project)
            ->where('transaction_type',1)
            ->where('project_payment_type',1)->sum('amount');

        return $totalBudgetPayment;
    }

    public function paidByProject($project){
        $total= ProjectWiseStakeholder::where('stakeholder_id', $this->id)
            ->where('project_id',$project)->first();
        return $total->budget_paid;
    }

    public function dueByProject($project){
        $total= ProjectWiseStakeholder::where('stakeholder_id', $this->id)
            ->where('project_id',$project)->first();
        return $total->budget_due;
    }

    //TotalProfitBudgetPayment
    public function getTotalProfitBudgetPaymentAttribute() {
        $totalProfitBudgetPayment= TransactionLog::where('stakeholder_id', $this->id)
            ->where('transaction_type',1)
            ->where('project_payment_type',2)->sum('amount');

        return $totalProfitBudgetPayment;
    }


}
