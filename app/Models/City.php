<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'name', 'slug', 'type', 'name_with_type', 'code'
    ];

    public function district()
    {
        return $this->hasMany('App\Models\District', 'parent_code', 'code');
    }

    public static function getAllCity()
    {
        return self::select('id', 'name', 'slug', 'type', 'name_with_type', 'code')
            ->get();
    }

    public static function getOptionCity()
    {
        $cities = self::getAllCity();

        $cityOption = [];

        $cityOption[''] = 'Please select a city';
        foreach ($cities as $city) {
            $cityOption[$city['code']] = $city['name'];
        }

        return $cityOption;
    }
}
