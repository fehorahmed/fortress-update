<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $guarded = [];

    public function products() {
        return $this->hasMany(ProductRequisition::class,'requisition_id','id');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function segment() {
        return $this->belongsTo(ProductSegment::class,'product_segment_id');
    }
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
