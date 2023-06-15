<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceResource extends JsonResource
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
            'vehicle' => $this->vehicle->reg_plate_number,
            'mileage' => $this->mileage,
            'date' => Carbon::parse($this->date)->format('M d, Y'),
            'service_type' => $this->service_type->name,
            'cost' => $this->cost,
            'place' => $this->place,
            'mechanic_name' => $this->mechanic_name,
            'comments' => $this->comments,
            'part_replaced' => $this->part_replaced,
            'part_repaired' => $this->part_repaired,
            'tyre_replaced' => $this->tyre_replaced
        ];
    }
}
