<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransfusionPoint\PointStoreRequest;
use App\Http\Requests\TransfusionPoint\PointUpdateRequest;
use App\Http\Resources\TransfusionPoint\BloodTypeTransfusionPointsResource;
use App\Http\Resources\TransfusionPoint\TransfusionPointResource;
use App\Models\TransfusionPoint;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransfusionPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransfusionPointResource::collection(TransfusionPoint::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PointStoreRequest $request)
    {
        $createdPoint = TransfusionPoint::create($request->validated());

        return new TransfusionPointResource($createdPoint);
    }

    /**
     * Display the specified resource.
     */
    public function show(TransfusionPoint $transfusionPoint)
    {
        return new TransfusionPointResource($transfusionPoint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PointUpdateRequest $request, TransfusionPoint $transfusionPoint)
    {
        $transfusionPoint->update($request->validated());

        return new TransfusionPointResource($transfusionPoint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransfusionPoint $transfusionPoint)
    {
        $transfusionPoint->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function missingBlood()
    {
        $points = DB::table('transfusion_points')
            ->join('blood_type_transfusion_points', 'transfusion_points.id', '=', 'blood_type_transfusion_points.transfusion_point_id')
            ->join('blood_types', 'blood_types.id', '=', 'blood_type_transfusion_points.blood_type_id')
            ->select('transfusion_points.*', 'blood_types.type', 'blood_type_transfusion_points.quantity')
            ->where('blood_type_transfusion_points.quantity', '<=', 5000)
            ->orderBy('id', 'asc')
            ->get();

        return BloodTypeTransfusionPointsResource::collection($points);
    }
}
