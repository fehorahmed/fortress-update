<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded=[];

    public function loanHolder()
    {
        return $this->belongsTo(LoanHolder::class,'loan_holder_id','id');
    }
    public function payments() {
        return $this->hasMany(LoanTransactionLog::class,'loan_id','id');
    }
}
