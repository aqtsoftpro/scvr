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
            'user' => $this->user->name,
            'vehicle' => $this->vehicle->make,
            'location' => $this->location->name,
            'reason_of_renting' => $this->reason_of_renting,
            'swap_with' => $this->swapWith->make,
            'rental_period' => $this->rental_priod,
            'mileage' => $this->mileage,
            'accessory' => $this->accessory->name,
            'due_return' => Carbon::parse($this->due_return)->format('d M, Y'),
            'date' => Carbon::parse($this->created_at)->format('d M, Y'),

        ];
    }
}
