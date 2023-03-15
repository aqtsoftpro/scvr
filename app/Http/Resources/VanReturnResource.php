<?php

namespace App\Http\Resources;

use App\VanOut;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VanReturnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rental_info' => new VanOutResource($this->van_out),
            'location' => $this->location,
            'mileage' => $this->mileage,
            'fuel_tank' => $this->fuel_tank,
            'condition' => $this->condition,
            'demage_caused_by_customer' => $this->demage_caused_by_customer,
            'demage_picture' => $this->demage_picture,
            'demage_text' => $this->demage_text,
        ];
    }
}
