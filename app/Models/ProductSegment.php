<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSegment extends Model
{
    protected $fillable = [
        'name','description', 'status'
    ];

    public function products() {
        return $this->hasMany(PurchaseProduct::class);
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function getTotalProgressAttribute() {
        $totalDone= PhysicalProgress::where('product_segment_id',$this->id)->sum('segment_progress_percentage');
        return $totalDone;
    }
}
