<?php

namespace App;

use App\Vehicle;
use App\Location;
use App\Accessory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function accessory(){
        return $this->belongsTo(Accessory::class);
    }

    public function swapWith(){
        return $this->belongsTo(Vehicle::class, 'swap_with');
    }

}
