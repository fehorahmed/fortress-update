<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
//    protected $fillable = ['project_id','name','unit_id','segment_id','code','description','estimate_cost','status'];
//    protected $guarded = [];
    use HasFactory;

    protected $table = 'purchase_products';
    protected $guarded = array();
    public function unit() {
        return $this->belongsTo(Unit::class);
    }
    public function segment() {
        return $this->belongsTo(ProductSegment::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
