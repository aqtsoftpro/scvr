<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanOut extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'location_id',
        'reason_of_renting',
        'swap_with',
        'rental_priod',
        'rental_amount',
        'mileage',
        'accessory_id',
        'due_return',
    ];
}
