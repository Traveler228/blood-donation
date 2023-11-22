<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\TransfusionPoint\TransfusionPointResource;
use App\Http\Resources\User\UserResource;
use App\Models\TransfusionPoint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $createdUser = User::create($request->validated());

        return new UserResource($createdUser);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function listBloodPoints()
    {
        if (isset(auth()->user()->city)) {
            $city = auth()->user()->city;
        }

        $points = TransfusionPoint::where('transfusion_points.city', '=', $city)->get();

        return TransfusionPointResource::collection($points);
    }

    public function honoraryDonors()
    {
        $honorary = User::whereNotNull('users.is_honorary')->orderBy('is_honorary', 'desc')->get()->take(5);

        return UserResource::collection($honorary);

    }

    public function possibilityDonation()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
        }

        $lastDonation = DB::table('users')
            ->join('donations', 'users.id', '=', 'donations.user_id')
            ->select('donations.date')
            ->where('donations.user_id', '=', $id)
            ->orderBy('date', 'desc')
            ->first()->date;

        return response()->json([
            'next_donation' => Carbon::parse($lastDonation)->addMonth(2)->toDateString(),
        ], 200);
    }
}
