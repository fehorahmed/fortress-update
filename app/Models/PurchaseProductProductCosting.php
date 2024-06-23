<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProductProductCosting extends Model
{
    protected $guarded =  [];

    public function product() {
        return $this->belongsTo(PurchaseProduct::class,'purchase_product_id');
    }
    public function unit() {
        return $this->belongsTo(Unit::class);
    }
    public function costing() {
        return $this->belongsTo(Costing::class,'costing_id','id');
    }
    public function requisitionReport($segment,$product){
        $ids=Requisition::where('product_segment_id',$segment)->pluck('id');
          $result=  ProductRequisition::whereIn('requisition_id',$ids)
            ->where('purchase_product_id',$product)->sum('quantity');

        return $result;
    }

}
