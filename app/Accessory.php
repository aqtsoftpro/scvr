<?php

namespace App;

use App\Http\Resources\VanoutOptionsResource;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accessory extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'name'
    ];

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }

    public function van_outs(){
        return $this->belongsToMany(Vanout::class, 'accessory_van_out');
    }
}
