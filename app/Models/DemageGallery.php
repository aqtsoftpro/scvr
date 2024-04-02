<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\{VanOut, VanReturn};


class DemageGallery extends Model
{
    use HasFactory;

    protected $fillable = ['van_out_id', 'van_return_id', 'image'];

    public function vanout(): BelongsTo
    {
        return $this->belongsTo(VanOut::class, 'van_out_id');
    }

    public function vanin(): BelongsTo
    {
        return $this->belongsTo(VanReturn::class, 'van_return_id');
    }

}
