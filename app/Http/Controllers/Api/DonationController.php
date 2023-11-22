<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donation\DonationStoreRequest;
use App\Http\Requests\Donation\DonationUpdateRequest;
use App\Http\Resources\Donation\DonationResource;
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
        return DonationResource::collection(Donation::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DonationStoreRequest $request)
    {
        $createdDonation = Donation::create($request->validated());

        $countDonation = Donation::where('user_id', '=', $request->user_id)->count();

        if ($countDonation >= 40) {
            User::find($request->user_id)->update([
                'is_honorary' => Carbon::now()->toDateString(),
            ]);
        }

        return new DonationResource($createdDonation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        return new DonationResource($donation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DonationUpdateRequest $request, Donation $donation)
    {
        $donation->update($request->validated());

        return new DonationResource($donation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
