<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function segments() {
        return $this->hasMany(ProductSegment::class);
    }
    public function projectStakeholders() {
        return $this->hasMany(ProjectWiseStakeholder::class);
    }
//    public function stakeholderPayment() {
//        return $this->hasOne(StakeholderPayment::class,'project_id');
//    }
    public function getTotalProgressAttribute() {

        $segmentTotal= ProductSegment::where('project_id',$this->id)->sum('segment_percentage');
        return $segmentTotal;
    }
    public function getTotalCompletedAttribute() {
        $segmentTotal= PhysicalProgress::where('project_id',$this->id)->sum('project_progress_percentance');
        return $segmentTotal;
    }
    public function getBudgetAttribute() {
        $budgetTotal= Budget::where('project_id',$this->id)->sum('budget');
        return $budgetTotal;
    }
    public function cash() {
        return $this->hasOne(Cash::class,'project_id');
    }
}
