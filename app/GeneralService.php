<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralService extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'general_service';
    protected $fillable = [
        'cost', 'place', 'mechanic_name', 'comments'
    ];

    public function serviceable(): MorphOne
    {
        return $this->morphOne(ServiceType::class, 'serviceable');
    }

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['id', 'cost', 'place', 'mechanic_name', 'comments'])
            ->logUnguarded();
    }
}
