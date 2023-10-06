<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VanReturn extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
      'van_out_id',
      'location_id',
      'mileage',
      'fuel_tank',
      'condition',
      'require_maintenance',
      'require_maintenance_text',
      'demage_caused_by_customer',
      'demage_picture',
      'demage_text',
      'return_date'
    ];

    public function location(){
      return $this->belongsTo(Location::class);
    }

    public function van_out(){
        return $this->belongsTo(VanOut::class, 'van_out_id');
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }
}
