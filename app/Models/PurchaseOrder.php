<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $guarded = [];

    public function products() {
       return $this->hasMany(ProductPurchaseOrder::class);
    }
    public function payments() {
        return $this->hasMany(PurchasePayment::class,'purchase_order_id','id');
    }
    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function segment() {
        return $this->belongsTo(ProductSegment::class,'segment_id');
    }

}
