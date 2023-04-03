<?php

namespace App;

use App\Maintenance;
use App\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'picture',
        'vehicle_type_id',
        'reg_plate_number',
        'model',
        'make',
        'vin',
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

    public function maintenance(){
        return $this->hasMany(Maintenance::class);
    }

    public function insurance(){
        return $this->hasOne(Insurance::class, 'vehicle_id');
    }

}
