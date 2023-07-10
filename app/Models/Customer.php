<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'dob', //date
        'gender', //string
        'occupation', //string
        'driver_licence_number', //string
        'driver_licence_front_picture', //image
        'driver_licence_back_picture', //image
        'driver_licence_expiry', //date
        'nationality', //string
        'secondary_id_number', //string
        'secondary_id_front_picture', //image
        'secondary_id_back_picture', //image
        'secondary_id_expiry'    //date
    ];


    public function tolls(){
        return $this->hasMany(Toll::class);
    }
}
