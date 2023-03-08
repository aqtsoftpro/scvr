<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ServiceType extends Model
{
    use HasFactory;

    public function serviceable(): MorphTo
    {
        return $this->morphTo();
    }
}
