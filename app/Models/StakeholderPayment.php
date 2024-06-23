<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeholderPayment extends Model
{
    use HasFactory;

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function account(){
        return $this->belongsTo(BankAccount::class,'bank_account_id');
    }
    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class);
    }

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }


}
