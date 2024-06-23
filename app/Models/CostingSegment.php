<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostingSegment extends Model
{

    public function estimateProject(){
        return $this->belongsTo(EstimateProject::class,'project_id');
    }
}
