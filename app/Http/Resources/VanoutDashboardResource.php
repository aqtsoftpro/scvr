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
            'vehicle_id' => $this->vehicle->id,
            'title' => $this->vehicle->make . '-' . $this->vehicle->model,
            'category' => $this->vehicle->status->name,
            'description' => $this->vehicle->reg_plate_number,
            'createDate' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'vanOutDate' => Carbon::parse($this->van_out_date)->format('Y-m-d'),
            'dueReturn' => Carbon::parse($this->due_return)->format('Y-m-d'),
        ];
    }
}
