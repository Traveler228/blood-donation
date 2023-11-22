<?php

namespace App\Http\Resources\Donation;

use App\Http\Resources\User\UserResource;
use App\Models\DonationType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
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
            'type' => DonationType::find($this->type_id)->type,
            'date' => $this->date,
            'confirming_document' => $this->confirming_document,
            'user' => new UserResource(User::find($this->user_id)),
            'created_at' => $this->created_at,
        ];
    }
}
