<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorPayment extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];

    public function purchaseOrder() {
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id','id');
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
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function contractor() {
        return $this->belongsTo(Contractor::class);
    }
}
