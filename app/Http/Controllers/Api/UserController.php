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
    public function show(User $user)
    {
        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.date_of_birth', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->where('users.id', '=', $user->id)
            ->orderBy('id')
            ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function userUpdate(UpdateRequest $request)
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
        }

        User::find($id)->update([
            'surname' => $request->surname,
            'name' => $request->name,
            'patronymic' => $request->patronymic,
            'city' => $request->city,
            'login' => $request->login,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return User::query()
            ->leftJoin('blood_types', 'users.blood_id', '=', 'blood_types.id')
            ->select('users.id', 'users.surname', 'users.name', 'users.patronymic', 'users.date_of_birth', 'users.city', 'blood_types.type', 'users.is_honorary')
            ->withCount('donations')
            ->where('users.id', '=', $id)
            ->get();
    }

    public function adminUpdate(UpdateRequest $request, string $id)
    {
        User::find($id)->update([
            'date_of_birth' => $request->date_of_birth,
            'is_honorary' => $request->is_honorary,
            'blood_id' => $request->blood_id,
            'role' => $request->role,
        ]);

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
