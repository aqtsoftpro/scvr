<?php

namespace App;

use App\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'picture',
        'vehicle_type_id',
        'model',
        'make',
        'VIN',
        'mileage',
        'purchase_date',
        'purchase_price',
        'seller_name',
        'seller_address',
        'seller_contact_number'
    ];

    public function vehicle_type(){
        return $this->belongsTo(VehicleType::class);
    }

}
