<?php

namespace App;

use App\VanOut;
use App\Maintenance;
use App\VehicleType;
use App\Models\VehicleStatus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, LogsActivity;
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
        'vehicle_condition',
        'seller_name',
        'seller_address',
        'seller_contact_number',
        'status_id',
        'next_maintenance_mileage',
        'next_maintenance_due_date',
        'next_maintenance_service',
        'next_maintenance_comments',
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

    public function status(){
        return $this->belongsTo(VehicleStatus::class);
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }

    public function vanouts(){
        return $this->hasMany(VanOut::class);
    }
}
