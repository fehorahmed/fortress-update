<?php

namespace App\Imports;

use App\Models\PurchaseProduct;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPurchaseProduct implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $unitId = 0;
        $unit = Unit::where('name',$row[1])
            ->where('project_id',Auth::user()->project_id)
            ->first();
        if($unit){
            $unitId = $unit->id;
        }else{
            $newUnit = new Unit();
            $newUnit->name = $row[1];
            $newUnit->project_id = Auth::user()->project_id;
            $newUnit->status = 1;
            $newUnit->save();
            $unitId = $newUnit->id;
        }
        return new PurchaseProduct([
            'name'     => $row[0],
            'unit_id'    => $unitId,
            'code'    => $row[2],
            'description'    => $row[3],
            'status'    => $row[4],
            'project_id' => Auth::user()->project_id,
        ]);
    }
}
