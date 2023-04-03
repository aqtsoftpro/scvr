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
        /**            id: 1,
          *title: 'Vehicle 1',
          *img: '/assets/img/van-white.jpg',
          *category: 'Rented',
          *createDate: '02.04.2018',
          *status: '2 DAYS',
          *statusColor: 'primary',
          *description: 'Van was rented for some offical purposes',
          *sales: 1647,
          *stock: 62
        **/
        return [
            'img' => $this->vehicle->picture,
            'id' => $this->id,
            'title' => $this->vehicle->make . '-' . $this->vehicle->model,
            'category' => 'Rented Out',
            'description' => $this->reason_of_renting,
            'createDate' => Carbon::parse($this->created_at)->format('M d, Y'),
        ];
    }
}
