<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'picture' => $this->picture,
            'type' => $this->vehicle_type->name,
            'model' => $this->model,
            'make' => $this->make,
            'VIN' => $this->VIN,
            'mileage' => $this->mileage,
            'purchase_date' => $this->purchase_date,
            'purchase_price' => $this->purchase_price,
            'seller_name' => $this->seller_name,
            'seller_address' => $this->seller_address,
            'seller_contact_number' => $this->seller_contact_number,
        ];
    }
}
