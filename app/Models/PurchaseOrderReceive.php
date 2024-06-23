<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderReceive extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(PurchaseProduct::class,'purchase_product_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
