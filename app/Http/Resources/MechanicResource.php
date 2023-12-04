<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MechanicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'workshop_contact' => $this->workshop_contact,
            'workshop_address' => $this->workshop_address,
            'expertise' => $this->expertise,
            'comments' => $this->comments,
            'added-updated' => Carbon::parse($this->created_at)->format('d-m-Y g:i A') . '/' .  Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
        ];
    }
}
