<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InsuranceResource extends JsonResource
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
            'company_name' => $this->company_name,
            'policy_number' => $this->policy_number,
            'policy_type' => $this->policy_type->name,
            'policy_type_id' => $this->policy_type->id,
            // 'policy_start_date' => Carbon::parse($this->policy_start_date)->format('d-m-Y'),
            'policy_start_date' => $this->policy_start_date,
            // 'policy_end_date' => Carbon::parse($this->policy_end_date)->format('d-m-Y'),
            'policy_end_date' => $this->policy_end_date,
            'road_side_assistance' => $this->road_side_assistance,
            'road_side_assistance_company' => $this->road_side_assistance_company,
            'road_side_assistance_start_date' => $this->road_side_assistance_start_date,
            'road_side_assistance_end_date' => $this->road_side_assistance_end_date,
            'demage_details' => $this->demage_details,
            'damage_picture' => $this->damage_picture,
            'added/updated' => Carbon::parse($this->created_at)->format('d-m-Y g:i A') . '/' .  Carbon::parse($this->updated_at)->format('d-m-Y g:i A'),
        ];
    }
}
