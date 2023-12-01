<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donation\DonationStoreRequest;
use App\Http\Requests\Donation\DonationUpdateRequest;
use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Donation::query()
            ->join('blood_types', 'donations.type_id', '=', 'blood_types.id')
            ->select('donations.id', 'blood_types.type', 'date', 'confirming_document', 'donations.user_id')
            ->orderBy('id')
            ->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DonationStoreRequest $request)
    {
        $id = Donation::create([
            'type_id' => $request->type_id,
            'date' => $request->date,
            'confirming_document' => $request->confirming_document,
            'user_id' => $request->user_id,
        ])->id;

        $countDonation = Donation::where('user_id', '=', $request->user_id)->count();

        if ($countDonation >= 10) {
            User::find($request->user_id)->update([
                'is_honorary' => Carbon::now()->toDateString(),
            ]);
        }

        return response()->json([
            'message' => 'Donation successfully created',
            'id_donation' => $id,
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Donation::query()
            ->join('blood_types', 'donations.type_id', '=', 'blood_types.id')
            ->select('donations.id', 'blood_types.type', 'date', 'confirming_document', 'donations.user_id')
            ->where('donations.id', '=', $id)
            ->orderBy('id')
            ->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DonationUpdateRequest $request, string $id)
    {
        Donation::find($id)->update($request->validated());

        return Donation::query()
            ->join('blood_types', 'donations.type_id', '=', 'blood_types.id')
            ->select('donations.id', 'blood_types.type', 'date', 'confirming_document', 'donations.user_id')
            ->where('donations.id', '=', $id)
            ->orderBy('id')
            ->get();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Donation::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
