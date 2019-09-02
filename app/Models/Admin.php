<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;

class Admin extends Authenticatable
{
    use SoftDeletes;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'admin_group_id', 'admin_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'admins';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function adminGroup()
    {
        return $this->belongsTo('App\Models\AdminGroup', 'admin_group_id', 'id');
    }

    public static function getListAllAdmin()
    {
        return self::select(
            'name', 'email', 'password',
            'admin_group_id', 'admin_status'
        )
            ->orderBy('id', 'DESC')->get();
    }

    public static function getListAdmin()
    {
        return self::select(
            'id', 'name', 'email', 'password',
            'admin_group_id', 'admin_status'
        )
            ->orderBy('id', 'DESC')->paginate(LIMIT);
    }

    public static function createNewAdmin($request)
    {
        if ($request['password'] !== '') {
            $request['password'] = Hash::make($request['password']);
        }
        return self::create($request);
    }

    public static function showAdmin($id)
    {
        return self::find($id);
    }

    public static function updateAdmin($id, $request)
    {
        $user = self::showAdmin($id);
        return $user->update($request);
    }

    public static function deleteAdmin($id)
    {
        $user = self::showAdmin($id);
        return $user->delete();
    }
}
