<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'dob' => Carbon::parse($this->dob)->format('d M, Y'),
            'gender' => ($this->gender == 1) ? 'Male' : 'Female',
            'occupation' => $this->occupation,
            'driver_licence_number' => $this->driver_licence_number,
            'driver_licence_front_picture' => $this->driver_licence_front_picture,
            'driver_licence_back_picture' => $this->driver_licence_back_picture,
            'driver_licence_expiry' => Carbon::parse($this->driver_licence_expiry)->format('d M, Y'),
            'nationality' => $this->nationality,
            'secondary_id_number' => $this->secondary_id_number,
            'secondary_id_front_picture' => $this->secondary_id_front_picture,
            'secondary_id_back_picture' => $this->secondary_id_back_picture,
            'secondary_id_expiry' => Carbon::parse($this->secondary_id_expiry)->format('d M, Y'),
            'vanouts' => $this->van_outs,
            'vanout_count' => $this->van_outs->count(),
        ];
    }
}
