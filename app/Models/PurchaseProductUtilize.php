<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProductUtilize extends Model
{
    protected $fillable = [
        'product_id','project_id','product_segment_id','quantity', 'date', 'note', 'purchase_inventory_log_id'
    ];

    protected $dates = ['date'];

    public function product() {
        return $this->belongsTo(PurchaseProduct::class, 'product_id', 'id')->with('unit');
    }
    public function purchaseOrder() {
        return $this->belongsTo(PurchaseOrder::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function segment()
    {
        return $this->belongsTo(ProductSegment::class,'product_segment_id','id');
    }
}
