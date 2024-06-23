<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInventoryLog extends Model
{
    protected $guarded = [];

   // protected $dates = ['date'];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function product() {
        return $this->belongsTo(PurchaseProduct::class, 'purchase_product_id', 'id')->with('unit');
    }
    public function purchase_order() {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }
}
