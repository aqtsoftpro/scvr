<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairJob extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'part_replaced',
        'cost',
        'place',
        'mechanic_name',
        'comments'
    ];

    public function service_type(): MorphOne
    {
        return $this->morphOne(ServiceType::class, 'serviceable');
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }
}
