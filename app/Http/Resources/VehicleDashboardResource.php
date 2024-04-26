<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'img' => $this->picture,
            'vehicle_id' => $this->id,
            'vehicle_type' => $this->vehicle_type->name,
            'vehicle_status' => $this->status->name,
            'vehicle_make_model' => $this->make . ' - ' . $this->model,
            'mileage' => $this->mileage,
            'condition' => $this->vehicle_condition	,
            'vehicle_reg_number' => $this->reg_plate_number,
        ];
    }
}
