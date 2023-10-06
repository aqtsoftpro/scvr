<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VanReturnDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'img' => ($this->van_out) ? $this->van_out->vehicle->picture : '',
            'vehicle_id' => ($this->van_out) ? $this->van_out->vehicle->id: '',
            'vehicle_status' => ($this->van_out) ? $this->van_out->vehicle->status->name: '',
            'vehicle_make_model' => ($this->van_out) ? $this->van_out->vehicle->make . ' - ' . $this->van_out->vehicle->model : '',
            'location' => $this->location->name,
            'mileage' => $this->mileage,
            'fuel_tank' => $this->fuel_tank,
            'condition' => $this->condition,
            'vehicle_reg_number' => ($this->van_out) ? $this->van_out->vehicle->reg_plate_number : '',
            'date' => Carbon::parse($this->return_date)->format('d-m-Y'),
        ];
    }
}
