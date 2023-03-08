<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairJob extends Model
{
    use HasFactory;

    public function service_type(): MorphOne
    {
        return $this->morphOne(ServiceType::class, 'serviceable');
    }
}
