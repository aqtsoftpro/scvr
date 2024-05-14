<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DemageGallery;
use App\{Location, VanOut};


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
      'return_date',
      'bond_return_amount',
      'total_driven',
      'days_count',
      'video',
      'bond_comment'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->days_count = $model->calculateNumberOfDays();
    //     });
    // }

    public function location(): BelongsTo
    {
      return $this->belongsTo(Location::class);
    }

    public function galleries(): HasMany
    {
      return $this->hasMany(DemageGallery::class);
    }

    public function van_out(): BelongsTo
    {
        return $this->belongsTo(VanOut::class, 'van_out_id');
    }

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }

}
