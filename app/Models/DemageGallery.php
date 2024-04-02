<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemageGallery extends Model
{
    use HasFactory;

    protected $fillable = ['van_out_id', 'van_return_id', 'image'];

}
