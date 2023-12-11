<?php

namespace App\Http\Controllers\Api;

use App\Enums\BloodTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AdminUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.date_of_birth', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->orderBy('id')
            ->paginate(20);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.date_of_birth', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->where('users.id', '=', $id)
            ->orderBy('id')
            ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function userUpdate(UserUpdateRequest $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
        }

        User::find($id)->update($request->validated());

        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.date_of_birth', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->where('users.id', '=', $id)
            ->get();
    }

    public function adminUpdate(AdminUpdateRequest $request, string $id)
    {
        User::find($id)->update($request->validated());

        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.date_of_birth', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->where('users.id', '=', $id)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function honoraryDonors()
    {
        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->whereNotNull('users.is_honorary')
            ->orderBy('is_honorary', 'desc')
            ->get()
            ->take(5);
    }

    public function possibilityDonation()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
        }

        $lastDonation = User::query()
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
