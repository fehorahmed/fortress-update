<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInventory extends Model
{
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(PurchaseProduct::class, 'product_id');
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function segment() {
        return $this->belongsTo(ProductSegment::class, 'segment_id');
    }

}
