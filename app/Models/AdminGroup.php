<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminGroup extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function admin()
    {
        return $this->hasMany('App\Models\Admin', 'admin_group_id', 'id');
    }

    public static function getOptionPermission()
    {
        $adminGroups = self::all();
        $permission = [];

        $permission[''] = 'Please select an admin permission';
        foreach ($adminGroups as $adminGroup) {
            $permission[$adminGroup['permission']] = $adminGroup['permission_name'];
        }

        return $permission;
    }
}
