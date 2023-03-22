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
            'img' => '/assets/img/van-white.jpg',
            'location' => $this->location->name,
            'mileage' => $this->mileage,
            'fuel_tank' => $this->fuel_tank,
            'condition' => $this->condition,
            'date' => Carbon::parse($this->created_at)->format('M d, Y'),
        ];
    }
}
