<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded =[];

    public function payments() {
        return $this->hasMany(PurchasePayment::class,'supplier_id','id')
            ->with('purchaseOrder');
    }

    public function getPaid() {
        $total_paid = PurchasePayment::where('supplier_id',$this->id)->sum('amount');
        return $total_paid;
    }

    public function getDueAttribute() {
        $total_paid = PurchasePayment::where('supplier_id',$this->id)->sum('amount');
        $total_amount = PurchaseOrder::where('supplier_id', $this->id)->sum('total');
        $total_due = $total_amount - $total_paid;

        return $total_due;
    }

    public function getPaidAttribute() {
        return PurchasePayment::where('supplier_id', $this->id)->sum('amount');
    }

    public function getTotalAttribute() {
        return PurchaseOrder::where('supplier_id', $this->id)->sum('total');
    }

    public function getRefundAttribute() {
        return PurchaseOrder::where('supplier_id', $this->id)->sum('refund');
    }
    public function totalByProject($project) {
        $result= PurchaseOrder::where('supplier_id', $this->id)
            ->where('project_id',$project)
            ->sum('total');
        return $result;
    }

    public function paidByProject($project) {
        $result= PurchaseOrder::where('supplier_id', $this->id)
            ->where('project_id',$project)
            ->sum('paid');
        return $result;
    }
    public function dueByProject($project) {
        $result= PurchaseOrder::where('supplier_id', $this->id)
            ->where('project_id',$project)
            ->sum('due');
        return $result;
    }
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
