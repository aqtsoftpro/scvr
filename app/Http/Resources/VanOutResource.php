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

        if ($this->swaps()->count() > 0) {
            $swap = $this->swaps()->with('location', 'accessories')->latest()->first();
            return [
                'id' => $this->id,
                'reg_number' => $swap->vehicle->reg_plate_number,
                'customer' => $swap->customer->first_name . ' ' . $this->customer->last_name,
                'customer_id' => $swap->customer->id,
                'vehicle' => $swap->vehicle->make,
                'vehicle_model' => $swap->vehicle->model,
                'vehicle_id' => $swap->vehicle->id,
                'location' => $swap->location?->name,
                'location_id' => $swap->location?->id,
                'reason_of_renting' => $this->reason_of_renting,
                'accessories' => (isset($swap->accessories)) ? AccessoryResource::collection($swap->accessories) : null,
                'swap_with' => $this->swap_with,
                'swaped_detail' => $this->swapWith ?? null,
                'rental_period' => $swap->rental_period,
                'rental_amount' => $swap->rental_amount,
                'amount_frequency' => $swap->amount_frequency,
                'mileage' => $swap->mileage,
                'long_term' => $swap->long_term,
                'due_return' => Carbon::parse($swap->due_return)->format('d-m-Y H:i'),
                'return_date' => $swap->long_term == 1? 'Long term' : Carbon::parse($swap->due_return)->format('d-m-Y H:i'),
                'van_out_date' => Carbon::parse($swap->out_date)->format('d-m-Y H:i'),
                'bond_deposit' => $swap->bond_deposit,
                'payment_mode' => $swap->payment_mode,
                'condition' => $swap->condition,
                'added' => Carbon::parse($swap->created_at)->format('d-m-Y g:i A'),
                'updated' => Carbon::parse($swap->updated_at)->format('d-m-Y g:i A'),
                'old_vehicle' => $this->vehicle_id,
                'vehicle_return_date' => $swap->vehicle_return_date,
                'vehicle_type_id' => $swap->vehicle?->vehicle_type_id,
    
            ];
        }
        else {
            return [
                'id' => $this->id,
                'reg_number' => $this->vehicle->reg_plate_number,
                'customer' => $this->customer->first_name . ' ' . $this->customer->last_name,
                'customer_id' => $this->customer->id,
                'vehicle' => $this->vehicle->make,
                'vehicle_model' => $this->vehicle->model,
                'vehicle_id' => $this->vehicle->id,
                'location' => $this->location->name,
                'location_id' => $this->location->id,
                'reason_of_renting' => $this->reason_of_renting,
                'accessories' => (isset($this->accessories)) ? AccessoryResource::collection($this->accessories) : null,
                'swap_with' => $this->swap_with,
                'swaped_detail' => $this->swapWith ?? null,
                'rental_period' => $this->rental_period,
                'rental_amount' => $this->rental_amount,
                'amount_frequency' => $this->amount_frequency,
                'mileage' => $this->mileage,
                'long_term' => $this->long_term,
                'due_return' => Carbon::parse($this->due_return)->format('d-m-Y H:i'),
                'return_date' => $this->long_term == 1? 'Long term' : Carbon::parse($this->due_return)->format('d-m-Y H:i'),
                'van_out_date' => Carbon::parse($this->van_out_date)->format('d-m-Y H:i'),
                'bond_deposit' => $this->bond_deposit,
                'payment_mode' => $this->payment_mode,
                'condition' => $this->condition,
                'added' => Carbon::parse($this->created_at)->format('d-m-Y g:i A'),
                'updated' => Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
                'old_vehicle' => $this->vehicle_id,
                'vehicle_return_date' => $this->vehicle_return_date,
                'vehicle_type_id' => $this->vehicle?->vehicle_type_id,
                // 'swaps' => $this->swaps,
    
            ];
        }   
        // return [
        //     'id' => $this->id,
        //     'reg_number' => $this->vehicle->reg_plate_number,
        //     'customer' => $this->customer->first_name . ' ' . $this->customer->last_name,
        //     'customer_id' => $this->customer->id,
        //     'vehicle' => $this->vehicle->make,
        //     'vehicle_model' => $this->vehicle->model,
        //     'vehicle_id' => $this->vehicle->id,
        //     'location' => $this->location->name,
        //     'location_id' => $this->location->id,
        //     'reason_of_renting' => $this->reason_of_renting,
        //     'accessories' => (isset($this->accessories)) ? AccessoryResource::collection($this->accessories) : null,
        //     'swap_with' => $this->swap_with,
        //     'swaped_detail' => $this->swapWith ?? null,
        //     'rental_period' => $this->rental_period,
        //     'rental_amount' => $this->rental_amount,
        //     'amount_frequency' => $this->amount_frequency,
        //     'mileage' => $this->mileage,
        //     'long_term' => $this->long_term,
        //     'due_return' => Carbon::parse($this->due_return)->format('d-m-Y H:i'),
        //     'return_date' => $this->long_term == 1? 'Long term' : Carbon::parse($this->due_return)->format('d-m-Y H:i'),
        //     'van_out_date' => Carbon::parse($this->van_out_date)->format('d-m-Y H:i'),
        //     'bond_deposit' => $this->bond_deposit,
        //     'payment_mode' => $this->payment_mode,
        //     'condition' => $this->condition,
        //     'added' => Carbon::parse($this->created_at)->format('d-m-Y g:i A'),
        //     'updated' => Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
        //     // 'swaps' => $this->swaps,

        // ];
    }
}
