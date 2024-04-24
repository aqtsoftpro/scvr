<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Customer, User, SwapGallery};
use App\{Vehicle, VanOut, Accessory};

class Swap extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'vehicle_id', 'parent_id', 'van_out_id', 'condition', 'video', 'amount', 'rem_amount', 'out_date',
        'amount_status', 'amount_tracking_id', 'vehicle_reg', 'added_by', 'updated_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->added_by = auth()->id(); // Generate slug from the name
        });

        static::updating(function ($model) {
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

    public function swapImages(): BelongsTo
    {
        return $this->belongsTo(SwapGallery::class);
    }

    public function accessories(): BelongsToMany
    {
        return $this->belongsToMany(Accessory::class);
    }
}
