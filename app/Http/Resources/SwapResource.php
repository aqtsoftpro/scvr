<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SwapResource extends JsonResource
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
            'vehicle_model' => $this->vehicle->model,
            'vehicle_id' => $this->vehicle->id,
            'location' => $this->location?->name,
            'location_id' => $this->location?->id,
            'accessories' => (isset($this->accessories)) ? AccessoryResource::collection($this->accessories) : null,
            'rental_period' => $this->rental_period,
            'rental_amount' => $this->rental_amount,
            'amount_frequency' => $this->amount_frequency,
            'mileage' => $this->mileage,
            'long_term' => $this->long_term,
            'due_return' => Carbon::parse($this->due_return)->format('d-m-Y H:i'),
            'return_date' => $this->long_term == 1? 'Long term' : Carbon::parse($this->due_return)->format('d-m-Y H:i'),
            'van_out_date' => Carbon::parse($this->out_date)->format('d-m-Y H:i'),
            'bond_deposit' => $this->bond_deposit,
            'payment_mode' => $this->payment_mode,
            'condition' => $this->condition,
            'added' => Carbon::parse($this->created_at)->format('d-m-Y g:i A'),
            'updated' => Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
            'images' => $this->swapImages,
            'vehicle_return_date' => $this->vehicle_return_date,
            'status' => $this->status,

        ];
    }
}
