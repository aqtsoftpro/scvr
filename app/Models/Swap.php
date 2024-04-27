<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Customer, User, SwapGallery};
use App\{Vehicle, VanOut, Accessory, Location};

class Swap extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'vehicle_id', 'parent_id', 'van_out_id', 'condition', 'video', 'amount', 'rem_amount', 'out_date',
        'amount_status', 'amount_tracking_id', 'vehicle_reg', 'added_by', 'updated_by',
        'long_term', 'status', 'due_return', 'location_id', 'rental_period', 
        'rental_amount', 'mileage', 'amount_frequency',  'bond_deposit',  'payment_mode', 'vehicle_return_date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->rental_period = $model->calculateNumberOfDays();
            // $model->long_term = $request->long_term ?? 0;
            $model->added_by = auth()->id(); // Generate slug from the name
        });

        static::updating(function ($model) {
            $model->rental_period = $model->calculateNumberOfDays();
            // $model->long_term = $request->long_term ?? 0;
            $model->updated_by = auth()->id(); // Generate slug from the name
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Swap::class);
    }

    public function vanOut(): BelongsTo
    {
        return $this->belongsTo(VanOut::class);
    }

    public function addBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function swapImages(): HasMany
    {
        return $this->hasMany(SwapGallery::class);
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class, 'accessory_swap');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function calculateNumberOfDays()
    {
        $vanOutDate = date_create($this->van_out_date);
        $dueReturn = date_create($this->due_return);    
        $diff = date_diff($vanOutDate, $dueReturn);
        return $diff->days;
    }
}
