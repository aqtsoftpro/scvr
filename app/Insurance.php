<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $table = 'insurance';

    protected $fillable = [
        'company_name',
        'policy_type_id',
        'policy_start_date',
        'policy_end_date',
        'road_side_assistance',
        'road_side_assistance_start_date',
        'road_side_assistance_end_date',
        'demage_details'
    ];
}
