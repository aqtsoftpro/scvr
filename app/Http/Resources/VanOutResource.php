<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VanOutResource extends JsonResource
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
            'reg_number' => $this->vehicle->reg_plate_number,
            'customer' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'customer_id' => $this->customer->id,
            'vehicle' => $this->vehicle->make,
            'vehicle_id' => $this->vehicle->id,
            'location' => $this->location->name,
            'location_id' => $this->location->id,
            'reason_of_renting' => $this->reason_of_renting,
            'accessories' => (isset($this->accessories)) ? AccessoryResource::collection($this->accessories) : null,
            'swap_with' => $this->swap_with,
            'rental_period' => $this->rental_period,
            'rental_amount' => $this->rental_amount,
            'amount_frequency' => $this->amount_frequency,
            'mileage' => $this->mileage,
            'due_return' => $this->due_return,
            'van_out_date' => $this->van_out_date,
            'bond_deposit' => $this->bond_deposit,
            'payment_mode' => $this->payment_mode,
            // 'due_return' => Carbon::parse($this->due_return)->format('Y-m-d'),
            // 'van_out_date' => Carbon::parse($this->van_out_date)->format('Y-m-d')

        ];
    }
}
