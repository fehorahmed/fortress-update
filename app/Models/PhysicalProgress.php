<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalProgress extends Model
{

    protected $guarded=[];
    public function segment(){
        return $this->belongsTo(ProductSegment::class,'product_segment_id');
    }

}
