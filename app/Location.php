<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }
}
