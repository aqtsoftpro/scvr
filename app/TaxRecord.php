<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_type_id',
        'amount',
        'date',
        'filer_name',
        'filer_contact',
        'accountant_fee',
        'comments'
    ];

    public function tax_type(){
        return $this->belongsTo(TaxType::class);
    }
}
