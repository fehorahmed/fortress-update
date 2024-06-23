<?php

namespace App\Models;

use App\Models\ProductSegment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorBudget extends Model
{
    protected $guarded =[];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function contractor(){
        return $this->belongsTo(Contractor::class);
    }

    public function segment(){
        return $this->belongsTo(ProductSegment::class,'segment_id');
    }
    public function porductSegment(){
        return $this->belongsTo(ProductSegment::class,'project_id');
    }

    public function payments() {
        return $this->hasMany(ContractorPayment::class,'contractor_budget_id','id');
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
}
