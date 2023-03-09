<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanReturn extends Model
{
    use HasFactory;
    protected $fillable = [
      'location_id',
      'mileage',
      'fuel_tank',
      'condition',
      'demage_caused_by_customer',
      'demage_picture',
      'demage_text'
    ];
}
