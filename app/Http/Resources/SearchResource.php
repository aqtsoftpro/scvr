<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
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
            'vehicle_type' => $this->vehicle_type->name,
            'reg_plate_number' => $this->reg_plate_number,
            'model' => $this->model,
            'make' => $this->make,
            'vin' => $this->vin,
            'mileage' => $this->mileage,
            'purchase_date' => Carbon::parse($this->purchase_date)->format('d-m-Y'),
            'purchase_price' => $this->purchase_price,
            'vehicle_condition' => $this->vehicle_condition,
            'seller_nme' => $this->seller_name,
            'seller_address' => $this->seller_address,
            'seller_contact_number' => $this->seller_contact_number
        ];
    }
}
