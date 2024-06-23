<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name','address','status'
    ];

    public function project(){

        return $this->belongsTo(Project::class);
    }
}
