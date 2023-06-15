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
        'toll_image'
    ];
}
