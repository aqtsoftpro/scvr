<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VanoutDashboardResource extends JsonResource
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
            'img' => $this->vehicle->picture,
            'vehicle_id' => $this->vehicle->id,
            'title' => $this->vehicle->make . '-' . $this->vehicle->model,
            'category' => $this->vehicle->reg_plate_number,
            'mileage' => $this->mileage,
            'due_return' => Carbon::parse($this->due_return)->format('d-m-Y'),
        ];
    }
}
