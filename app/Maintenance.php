<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{

    use HasFactory;

    protected $table = 'maintenance';
    protected $fillable = [
        'vehicle_id',
        'mileage',
        'date',
        'service_type_id',
        'cost',
        'place',
        'mechanic_name',
        'comments',
        'part_replaced'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function service_type(){
        return $this->belongsTo(ServiceType::class);
    }
}
