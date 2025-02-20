<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWiseStakeholder extends Model
{
    use HasFactory;

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class);
    }
}
