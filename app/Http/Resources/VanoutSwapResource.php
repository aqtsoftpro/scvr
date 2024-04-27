<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VanoutSwapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->swaps()->count() > 0) {
            $swap_data = $this->swaps()->latest()->first();
            $vehicle = $swap_data->vehicle->make;
            $reg_number = $swap_data->vehicle->reg_plate_number;
            $model = $swap_data->vehicle->model;
            $rental_period = $swap_data->rental_period;
            $rental_amount = $swap_data->rental_amount;
            $amount_frequency = $swap_data->amount_frequency;
            $mileage = $swap_data->mileage;
            $long_term = $swap_data->long_term;
            $location = $swap_data->location->name;
            $location_id = $swap_data->location_id;
            $accessories = (isset($swap_data->accessories)) ? AccessoryResource::collection($swap_data->accessories) : null;
        }
        else {
            $vehicle = $this->vehicle->make;
            $reg_number = $this->vehicle->reg_plate_number;
            $model = $this->vehicle->model;
            $rental_period = $this->rental_period;
            $rental_amount = $this->rental_amount;
            $amount_frequency = $this->amount_frequency;
            $mileage = $this->mileage;
            $long_term = $this->long_term;
            $location = $this->location->name;
            $location_id = $this->location_id;
            $accessories = (isset($this->accessories)) ? AccessoryResource::collection($this->accessories) : null;
        }


        return [
            'id' => $this->id,
            'reg_number' => $reg_number,
            'customer' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'customer_id' => $this->customer->id,
            'vehicle' => $vehicle,
            'vehicle_model' => $model,
            'vehicle_id' => $this->vehicle_id,
            'location' => $location,
            'location_id' => $location_id,
            'accessories' => (isset($this->accessories)) ? AccessoryResource::collection($this->accessories) : null,
            'rental_period' => $rental_period,
            'rental_amount' => $rental_amount,
            'amount_frequency' => $amount_frequency,
            'mileage' => $mileage,
            'long_term' => $this->long_term,
        ];
    }
}
