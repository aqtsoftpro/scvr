<?php

namespace App;

use App\Vehicle;
use App\Location;
use App\Accessory;
use App\Models\Customer;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VanOut extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'location_id',
        'reason_of_renting',
        'swap_with',
        'rental_priod',
        'rental_amount',
        'mileage',
        'accessory_id',
        'due_return',
        'status'
    ];

    public function van_return(){
        return $this->hasOne(VanReturn::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
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

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }

}
