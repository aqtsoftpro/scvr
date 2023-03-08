<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function type(){
        return $this->hasOne(VehicleType::class);
    }
}
