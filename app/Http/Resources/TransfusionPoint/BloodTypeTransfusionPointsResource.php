<?php

namespace App\Http\Resources\TransfusionPoint;

use App\Models\TransfusionPoint;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodTypeTransfusionPointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'transfusion_point' => new TransfusionPointResource(TransfusionPoint::find($this->id)),
            'blood_type' => $this->type,
            'quantity' => $this->quantity,

        ];
    }
}
