<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_id', 'branch_id', 'account_name', 'account_no', 'account_code',
        'description', 'opening_balance', 'balance', 'status'
    ];

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
