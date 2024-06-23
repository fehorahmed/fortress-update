<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransfer extends Model
{
    public function log(){
        return $this->hasOne(TransactionLog::class,'id','balance_transfer_id');
    }
    public function sourcebank(){
        return $this->hasOne(Bank::class,'id','source_bank_id');
    }
    public function targetbank(){
        return $this->hasOne(Bank::class,'id','target_bank_id');
    }
    public function sourceaccount(){
        return $this->hasOne(BankAccount::class,'id','source_bank_account_id');
    }
    public function targetaccount(){
        return $this->hasOne(BankAccount::class,'id','target_bank_account_id');
    }
    public function target_branch()
    {
        return $this->belongsTo(Branch::class, 'target_branch_id');
    }
    public function target_bank_account()
    {
        return $this->belongsTo(BankAccount::class, 'target_bank_account_id');
    }
    public function source_branch()
    {
        return $this->belongsTo(Branch::class, 'source_branch_id');
    }
    public function source_bank_account()
    {
        return $this->belongsTo(BankAccount::class, 'source_bank_account_id');
    }
}
