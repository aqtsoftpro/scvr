<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Swap;

class SwapGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'swap_id', 'image' 
    ];


    public function swap(): BelongsTo
    {
        return $this->belongsTo(Swap::class);
    }
}
