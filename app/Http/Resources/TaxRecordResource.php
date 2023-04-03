<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxRecordResource extends JsonResource
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
            'type' => $this->tax_type->name,
            'amount' => $this->amount,
            'date' => Carbon::parse($this->date)->format('d M, Y'),
            'filer_name' => $this->filer_name,
            'filer_contact' => $this->filer_contact,
            'accountant_fee' => $this->accountant_fee,
            'comments' => $this->comments
        ];
    }
}
