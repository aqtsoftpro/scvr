<?php

namespace App;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxRecord extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name'])
            ->logUnguarded();
    }
}
