<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'name', 'slug', 'type', 'name_with_type', 'path', 'path_with_type', 'code', 'parent_code'
    ];

    public function wards()
    {
        return $this->hasMany('App\Models\Wards', 'parent_code', 'code');
    }

    public function cities()
    {
        return $this->belongsTo('App\Models\City', 'parent_code', 'code');
    }

    public static function getAllDistrict()
    {
        return self::select('id', 'name', 'slug', 'type', 'name_with_type', 'path', 'path_with_type', 'code', 'parent_code')
            ->get();
    }

    public static function getDistrictByCityId($city_id)
    {
        return self::select('id', 'name', 'slug', 'type', 'name_with_type', 'path', 'path_with_type', 'code', 'parent_code')
            ->where('parent_code', $city_id)
            ->get();
    }

    public static function getOptionDistrict($city_id = null)
    {
        $districts = self::getDistrictByCityId($city_id);

        $districtOption = [];

        $districtOption[''] = 'Please select a district';
        if (count($districts)) {
            foreach ($districts as $district) {
                $districtOption[$district['code']] = $district['name'];
            }
        }

        return $districtOption;
    }
}
