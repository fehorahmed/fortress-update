<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;
    protected $fillable = ['stakeholder_id','message','mobile_no','quantity'];

    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }
}
