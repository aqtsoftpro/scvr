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
            'policy_start_date' => Carbon::parse($this->policy_start_date)->format('d M, Y'),
            'policy_end_date' => Carbon::parse($this->policy_end_date)->format('d M, Y'),
            'road_side_assistance' => $this->road_side_assistance,
            'road_side_assistance_company' => $this->road_side_assistance_company,
            'road_side_assistance_start_date' => Carbon::parse($this->road_side_assistance_start_date)->format('d M, Y'),
            'road_side_assistance_end_date' => Carbon::parse($this->road_side_assistance_end_date)->format('d M, Y'),
            'demage_details' => $this->demage_details,
            'damage_picture' => $this->damage_picture
        ];
    }
}
