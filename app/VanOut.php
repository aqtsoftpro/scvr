<?php

namespace App;

use App\Vehicle;
use App\Location;
use App\Accessory;
use App\Http\Resources\AccessoryResource;
use App\Models\AccessoryVanout;
use App\Models\{Customer, DemageGallery, Swap};
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class VanOut extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'vehicle_id',
        'location_id',
        'reason_of_renting',
        'swap_with',
        'rental_period',
        'rental_amount',
        'amount_frequency',
        'mileage',
        'due_return',
        'status',
        'van_out_date',
        'bond_deposit',
        'payment_mode',
        'video',
        'condition',
        'long_term'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->rental_period = $model->calculateNumberOfDays();
        });
    }

    public function van_return(): HasOne
    {
        return $this->hasOne(VanReturn::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'first_name' => 'Name',
            'last_name' => 'Not found'
        ]);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function swapWith(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'swap_with');
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class, 'accessory_van_out');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(DemageGallery::class);
    }

    public function swaps(): HasOne
    {
        return $this->hasOne(Swap::class);
    }

    public function calculateNumberOfDays()
    {
        $vanOutDate = date_create($this->van_out_date);
        $dueReturn = date_create($this->due_return);    
        $diff = date_diff($vanOutDate, $dueReturn);
        return $diff->days;
    }

}
