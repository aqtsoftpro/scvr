<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TollResource extends JsonResource
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
            'toll_number' => $this->toll_number,
            'date' => Carbon::parse($this->date)->format('d M, Y'),
            'reg_plate_number' => $this->reg_plate_number,
            'customer' => (isset($this->customer)) ? $this->customer->first_name . ' ' . $this->customer->last_name : '',
            'toll_image' => $this->toll_image
        ];
    }
}
