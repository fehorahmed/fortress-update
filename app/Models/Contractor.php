<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $guarded =[];

    public function payments() {
        return $this->hasMany(ContractorPayment::class,'contractor_id','id');
//            ->with('purchaseOrder');
    }


    public function getDueAttribute() {
        $total = ContractorBudget::where('contractor_id', $this->id)->sum('total');
        $paid = ContractorPayment::where('contractor_id', $this->id)->sum('amount');
        $due = $total - $paid;
        return $due;
    }

    public function getPaidAttribute() {
        return ContractorPayment::where('contractor_id', $this->id)->sum('amount');
    }

    public function getTotalAttribute() {
        return ContractorBudget::where('contractor_id', $this->id)->sum('total');
    }

    public function getRefundAttribute() {
        return ContractorBudget::where('contractor_id', $this->id)->sum('refund');
    }
    public function totalByProject($project) {
        $result= ContractorBudget::where('contractor_id', $this->id)
            ->where('project_id',$project)
            ->sum('total');
        return $result;
    }

    public function paidByProject($project) {
        $result= ContractorBudget::where('contractor_id', $this->id)
            ->where('project_id',$project)
            ->sum('paid');
        return $result;
    }
    public function dueByProject($project) {
        $result= ContractorBudget::where('contractor_id', $this->id)
            ->where('project_id',$project)
            ->sum('due');
        return $result;
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function segment(){
        return $this->belongsTo(ProductSegment::class);
    }
}
