<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costing extends Model
{
    protected $guarded = [];

    public function estimateProducts() {
        return $this->hasMany(PurchaseProductProductCosting::class,'costing_id','id');
    }

    public function project() {
        return $this->belongsTo(Project::class,'estimate_project_id','id');
    }
    public function segment() {
        return $this->belongsTo(ProductSegment::class,'costing_type_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }




}
