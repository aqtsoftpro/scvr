<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toll extends Model
{
    use HasFactory;
    protected $fillable = [
        'toll_number',
        'date',
        'reg_plate_number',
        'customer_id',
        'toll_image',
        'bond_deposit',
        'payment_mode'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
