<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->roles[0]->id,
            'role_name' => $this->roles[0]->name,
            'added/updated' => Carbon::parse($this->created_at)->format('d-m-Y g:i A') . '/' .  Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
        ];
    }
}
