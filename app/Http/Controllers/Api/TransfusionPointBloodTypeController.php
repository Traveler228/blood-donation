<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\TransfusionPoint;
use Illuminate\Http\Request;

class TransfusionPointBloodTypeController extends Controller
{
    public function update(Request $request, string $id)
    {
        $bloodType = json_decode($request->blood, true);

        foreach ($bloodType as $key => $value) {
            $item = BloodType::find($key);
            $item->transfusionPoints()->newPivotQuery()->updateOrInsert(['transfusion_point_id'=>$id, 'blood_type_id'=>$key], ['quantity'=>$value]);
        }

        return response()->json([
            'message' => 'Blood type successfully updated',
            'id_transfuion_point' => $id,
        ], 201);

    }
}
