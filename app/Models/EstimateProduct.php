<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateProduct extends Model
{


    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id','id');
    }
}
