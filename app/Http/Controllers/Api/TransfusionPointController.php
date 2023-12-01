<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransfusionPoint\PointStoreRequest;
use App\Http\Requests\TransfusionPoint\PointUpdateRequest;
use App\Http\Requests\TransfusionPoint\TypePointRequest;
use App\Http\Resources\TransfusionPoint\BloodTypeTransfusionPointsResource;
use App\Http\Resources\TransfusionPoint\TransfusionPointResource;
use App\Models\BloodType;
use App\Models\BloodTypeTransfusionPoint;
use App\Models\TransfusionPoint;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransfusionPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransfusionPoint::query()
            ->leftJoin('blood_type_transfusion_points', 'transfusion_points.id', '=', 'blood_type_transfusion_points.transfusion_point_id')
            ->leftJoin('blood_types', 'blood_types.id', '=', 'blood_type_transfusion_points.blood_type_id')
            ->select('transfusion_points.id', 'transfusion_points.city', 'transfusion_points.full_address', 'transfusion_points.geolocation', 'blood_types.type', 'blood_type_transfusion_points.quantity')
            ->orderBy('id')
            ->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PointStoreRequest $request)
    {
        $pointId = TransfusionPoint::create([
            'city' => $request->city,
            'full_address' => $request->full_address,
            'geolocation' => $request->geolocation,
        ])->id;

        if (isset($request->blood)) {
            $data = array(
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
            );

            $datablood = json_decode($request->blood, true);

            foreach($datablood as $key => $value)
            {
                $data[$key] = $value;
            }

            foreach ($data as $key => $value) {
                $item = BloodType::find($key);
                $item->transfusionPoints()->attach($pointId, ['quantity' => $value]);
            }
        }

        return response()->json([
            'message' => 'Transfusion point successfully created',
            'id_donation' => $pointId,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return TransfusionPoint::query()
            ->leftJoin('blood_type_transfusion_points', 'transfusion_points.id', '=', 'blood_type_transfusion_points.transfusion_point_id')
            ->leftJoin('blood_types', 'blood_types.id', '=', 'blood_type_transfusion_points.blood_type_id')
            ->select('transfusion_points.id', 'transfusion_points.city', 'transfusion_points.full_address', 'transfusion_points.geolocation', 'blood_types.type', 'blood_type_transfusion_points.quantity')
            ->where('transfusion_points.id', '=', $id)
            ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PointUpdateRequest $request, string $id)
    {
        TransfusionPoint::find($id)->update([
            'city' => $request->city,
            'full_address' => $request->full_address,
            'geolocation' => $request->geolocation,
        ]);

        if (isset($request->blood)) {
            $data = json_decode($request->blood, true);

            foreach ($data as $key => $value) {
                $item = BloodType::find($key);
                $item->transfusionPoints()->updateExistingPivot($id, ['quantity' => $value]);
            }
        }

        return response()->json([
            'message' => 'Transfusion point successfully updated',
            'id_donation' => $id,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TransfusionPoint::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function listBloodPoints()
    {
        if (isset(auth()->user()->city)) {
            $city = auth()->user()->city;
        }

        return TransfusionPoint::query()
            ->leftJoin('blood_type_transfusion_points', 'transfusion_points.id', '=', 'blood_type_transfusion_points.transfusion_point_id')
            ->leftJoin('blood_types', 'blood_types.id', '=', 'blood_type_transfusion_points.blood_type_id')
            ->select('transfusion_points.id', 'transfusion_points.city', 'transfusion_points.full_address', 'transfusion_points.geolocation', 'blood_types.type', 'blood_type_transfusion_points.quantity')
            ->where('transfusion_points.city', '=', $city)
            ->orderBy('id')
            ->paginate(20);
    }

    public function missingBlood()
    {
        return TransfusionPoint::query()
            ->leftJoin('blood_type_transfusion_points', 'transfusion_points.id', '=', 'blood_type_transfusion_points.transfusion_point_id')
            ->leftJoin('blood_types', 'blood_types.id', '=', 'blood_type_transfusion_points.blood_type_id')
            ->select('transfusion_points.id', 'transfusion_points.city', 'transfusion_points.full_address', 'transfusion_points.geolocation', 'blood_types.type', 'blood_type_transfusion_points.quantity')
            ->where('blood_type_transfusion_points.quantity', '<=', 5000)
            ->orderBy('id')
            ->paginate(20);
    }
}