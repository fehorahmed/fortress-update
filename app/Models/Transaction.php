<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    protected $dates = ['date'];

    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function accountHeadType() {
        return $this->belongsTo(AccountHeadType::class);
    }

    public function accountHeadSubType() {
        return $this->belongsTo(AccountHeadSubType::class);
    }

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function account() {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }
    public function segment() {
        return $this->belongsTo(ProductSegment::class, 'product_segment_id', 'id');
    }

}
