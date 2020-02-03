<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    protected $table = 'wards';

    protected $fillable = [
        'name', 'slug', 'type', 'name_with_type', 'path', 'path_with_type', 'code', 'parent_code'
    ];

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'parent_code', 'code');
    }

    public static function getAllWards()
    {
        return self::select('id', 'name', 'slug', 'type', 'name_with_type', 'path', 'path_with_type', 'code', 'parent_code')
            ->get();
    }

    public static function getWardsByDistrictId($district_id)
    {
        return self::select('id', 'name', 'slug', 'type', 'name_with_type', 'path', 'path_with_type', 'code', 'parent_code')
            ->where('parent_code', $district_id)
            ->get();
    }

    public static function getOptionWards($district_id = null)
    {
        $wards = self::getWardsByDistrictId($district_id);
        if (empty($district_id)) {
            $wards = self::getAllWards();
        }

        $wardsOption = [];

        $wardsOption[''] = 'Please select a wards';
        if (count($wards)) {
            foreach ($wards as $ward) {
                $wardsOption[$ward['code']] = $ward['name'];
            }
        }

        return $wardsOption;
    }
}
