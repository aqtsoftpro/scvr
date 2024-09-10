<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VanOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer'],
            'vehicle_id' => ['required', 'integer'],
            'location_id' => ['required', 'integer'],
            'reason_of_renting' => ['required'],
            'rental_amount' => ['required'],
            'amount_frequency' => ['required'],
            'mileage' => ['required'],
            'van_out_date' => ['required'],
            'accessories' => ['required'],
            'demage_video' => ['mimes:mp4', 'max:5120']
        ];
    }
}
