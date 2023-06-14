<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Insurance extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'insurance';

    protected $fillable = [
        'vehicle_id',
        'company_name',
        'policy_number',
        'policy_type_id',
        'policy_start_date',
        'policy_end_date',
        'road_side_assistance',
        'road_side_assistance_company',
        'road_side_assistance_start_date',
        'road_side_assistance_end_date',
        'demage_details',
        'damage_picture'
    ];

    public function policy_type(){
        return $this->belongsTo(PolicyType::class);
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }
}
