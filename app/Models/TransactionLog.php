<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $guarded = [];

    protected $dates = ['date'];
    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }
    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function account() {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }
    public function salepayment(){
        return $this->belongsTo(SalePayment::class,'sale_payment_id');
    }
    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
    public function stakeholder(){
        return $this->belongsTo(Stakeholder::class,'stakeholder_id');
    }
    public function accountSubHead(){
        return $this->belongsTo(AccountHeadSubType::class,'account_head_sub_type_id','id');
    }
    public function purchasePayment(){
        return $this->belongsTo(PurchasePayment::class,'purchase_payment_id','id');
    }
    public function accountHead(){
        return $this->belongsTo(AccountHeadType::class,'account_head_type_id','id');
    }
    public function accountHeadType(){
        return $this->belongsTo(AccountHeadType::class,'transaction_type');
    }
    public function transaction(){
        return $this->belongsTo(Transaction::class,'transaction_id','id');
    }

}
