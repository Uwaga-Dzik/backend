<?php

namespace App\Http\Utils;

class CoordinatesHelper {

    public static function coordinatesPlusMeters(float $latitude, float $longitude, float $meters){
        $earthRadius = 6378.137;
        $m = (1 / ((2 * pi() / 360) * $earthRadius)) / 1000; //1 meter in degree
        $new_latitude = $latitude + ($meters * $m);
        $new_longitude = $longitude + ($meters * $m) / cos($latitude * (pi() / 180));
        return [
            'latitude' => $new_latitude,
            'longitude' => $new_longitude,
        ];
    }
}
