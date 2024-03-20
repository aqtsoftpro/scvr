<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{

    use HasFactory, LogsActivity;

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
        'part_replaced',
        'part_repaired',
        'tyre_replaced'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function service_type(){
        return $this->belongsTo(ServiceType::class);
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }
}
