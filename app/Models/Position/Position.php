<?php

namespace App\Models\Position;

use App\Models\Report\Report;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Position\Position
 *
 * @property int $id
 * @property float $latitude
 * @property float $longitude
 * @property string|null $country
 * @property string|null $voivodeship
 * @property string|null $subregion
 * @property string|null $disctrict
 * @property string|null $city
 * @property string|null $street
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Report $report
 * @method static \Illuminate\Database\Eloquent\Builder|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereDisctrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereSubregion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereVoivodeship($value)
 * @mixin \Eloquent
 */
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
        'report_id'
    ];

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
