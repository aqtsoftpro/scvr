<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowVanReturnResource extends JsonResource
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
            'vehicle_name' => $this->van_out ? $this->van_out->vehicle?->reg_plate_number : null,
            'customer' => ($this->van_out ? $this->van_out->customer?->first_name : '') . ' ' . ($this->van_out ? $this->van_out->customer?->last_name : ''),
            'customer_id' => $this->van_out?->customer?->id,
            'rental_amount' => $this->van_out?->rental_amount?? null,
            'rental_period' => Carbon::parse($this->van_out?->van_out_date)->format('d-m-Y H:i'),
            'location' => $this->location->name ?? null,
            'van_out_id' => $this->van_out?->id ?? null,
            'location_id' => $this->location->id,
            'mileage' => $this->mileage,
            'fuel_tank' => $this->fuel_tank,
            'condition' => $this->condition,
            'demage_caused_by_customer' => $this->demage_caused_by_customer,
            // 'damage_caused_by_customer' => ($this->demage_caused_by_customer == 0) ? 'No' : 'Yes',
            'demage_picture' => $this->demage_picture,
            'galleries' => $this->galleries,
            'demage_text' => $this->demage_text,
            'total_driven' => $this->total_driven.' (Km)',
            'days_count' => $this->days_count,
            // 'return_date' => Carbon::parse($this->return_date)->format('d-m-Y'),
            'return_date' => $this->return_date,
            // 'require_maintenance' => ($this->require_maintenance == 0) ? 'No' : 'Yes',
            'require_maintenance' => $this->require_maintenance,
            'require_maintenance_text' => $this->require_maintenance_text,
            'bond_return_amount' => $this->bond_return_amount,
            'added' => Carbon::parse($this->created_at)->format('d-m-Y g:i A'),
            'updated' => Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
            'van_out' => $this->van_out,
            'swaps' => SwapResource::collection($this->van_out->swaps),
            'bond_diff' => $this->bond_diff,
            'bond_comment' => $this->bond_comment
        ];
    }
}
