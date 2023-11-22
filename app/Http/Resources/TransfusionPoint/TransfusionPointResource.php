<?php

namespace App\Http\Resources\TransfusionPoint;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransfusionPointResource extends JsonResource
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
            'city' => $this->city,
            'full_address' => $this->full_address,
            'geolocation' => $this->geolocation,
            'created_at' => $this->created_at,
        ];
    }
}
