<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\InsuranceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'picture' => $this->picture,
            'type' => $this->vehicle_type->name,
            'type_id' => $this->vehicle_type->id,
            'reg_plate_number' => $this->reg_plate_number,
            'model' => $this->model,
            'make' => $this->make,
            'vin' => $this->vin,
            'mileage' => $this->mileage,
            'purchase_date' => Carbon::parse($this->purchase_date)->format('M d, Y'),
            // currency format purchase price
            'purchase_price' => $this->purchase_price,
            'vehicle_condition' => $this->vehicle_condition,
            'seller_name' => $this->seller_name,
            'seller_address' => $this->seller_address,
            'seller_contact_number' => $this->seller_contact_number,
            'insurance' => new InsuranceResource($this->insurance),
            'maintenance' => MaintenanceResource::collection($this->maintenance),
            'status' => $this->status->name,
            'status_id' => $this->status_id,
            'condition' => $this->vehicle_condition,
            'next_maintenance_mileage' => $this->next_maintenance_mileage,
            'next_maintenance_due_date' => Carbon::parse($this->next_maintenance_due_date)->format('M d, Y'),
            'next_maintenance_service' => $this->next_maintenance_service,
            'next_maintenance_comments' => $this->next_maintenance_comments,
        ];
    }
}
