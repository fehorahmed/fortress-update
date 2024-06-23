<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequisition extends Model
{
    protected $guarded =  [];

    public function product() {
        return $this->belongsTo(PurchaseProduct::class,'purchase_product_id','id');
    }
    public function unit() {
        return $this->belongsTo(Unit::class);
    }
    public function requisition() {
        return $this->belongsTo(Requisition::class);
    }
    public function purchaseTotal($project){
        $purchases = ProductPurchaseOrder::where('project_id', $project)
              ->where('product_id',$this->purchase_product_id)
                ->sum('quantity');
        return $purchases;
    }
}
