<?php

namespace App\Http\Resources;

use App\VanOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\VanOutResource;
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
            'id' => $this->id,
            'vehicle' => $this->van_out->vehicle->reg_plate_number,
            'customer' => $this->van_out->customer->first_name . ' ' . $this->van_out->customer->last_name,
            'customer_id' => $this->van_out->customer->id,
            'location' => $this->location->name,
            'van_out_id' => $this->van_out->id,
            'location_id' => $this->location->id,
            'mileage' => $this->mileage,
            'fuel_tank' => $this->fuel_tank,
            'condition' => $this->condition,
            'demage_caused_by_customer' => $this->demage_caused_by_customer,
            'demage_picture' => $this->demage_picture,
            'demage_text' => $this->demage_text,
            'return_date' => Carbon::parse($this->return_date)->format('d M, Y'),
            'require_maintenance' => ($this->require_maintenance == 0) ? 'No' : 'Yes',
            'require_maintenance_text' => $this->require_maintenance_text
        ];
    }
}
