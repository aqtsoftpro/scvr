<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class GeneralService extends Model
{
    use HasFactory;
    protected $table = 'general_service';
    protected $fillable = [
        'cost', 'place', 'mechanic_name', 'comments'
    ];

    public function serviceable(): MorphOne
    {
        return $this->morphOne(ServiceType::class, 'serviceable');
    }
}
