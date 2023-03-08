<?php

namespace App;

use App\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];


    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
