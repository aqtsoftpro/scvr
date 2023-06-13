<?php

namespace App\Models;

use App\Accessory;
use App\VanOut;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessoryVanout extends Model
{
    use HasFactory;
    protected $table = 'accessory_van_out';

    public function accessory(){
        return $this->belongsTo(Accessory::class);
    }

    public function van_out(){
        return $this->belongsTo(VanOut::class);
    }
}
