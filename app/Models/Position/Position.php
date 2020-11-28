<?php

namespace App\Models\Position;

use App\Models\Report\Report;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'country',
        'voivodeship',
        'subregion', // powiat
        'district', //gmina
        'city',
        'street',
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
