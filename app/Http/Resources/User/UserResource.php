<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Donation\DonationResource;
use App\Models\BloodType;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'surname' => $this->surname,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'date_of_birth' => $this->date_of_birth,
            'city' => $this->city,
            'blood_type' => BloodType::find($this->blood_id)->type,
            'is_honorary' => $this->is_honorary,
            'login' => $this->login,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'number_donations' => DonationResource::collection($this->donations)->count(),
        ];
    }
}
