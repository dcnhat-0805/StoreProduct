<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;

class User extends Authenticatable
{
    use SoftDeletes;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'birthday', 'gender', 'password',
        'phone', 'address', 'social_id',
        'avatar', 'code', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public static function getListAllUser()
    {
        return self::select(
                'name', 'email', 'password',
                'phone', 'address', 'social_id',
                'avatar', 'status'
            )
            ->orderBy('id', 'DESC')->get();
    }

    public static function getListUser()
    {
        return self::select(
            'name', 'email', 'password',
            'phone', 'address', 'social_id',
            'avatar', 'status'
        )
            ->orderBy('id', 'DESC')->paginate(5);
    }

    public static function createUser($request)
    {
        if ($request['password_user'] !== '') {
            $request['password'] = Hash::make($request['password_user']);
        }
        if (isset($request['wards']) && $request['wards']) {
            $request['address'] = $request['wards'];
        }

        if ($request['birthday_year'] && $request['birthday_month'] && $request['birthday_day']) {
            $request['birthday'] = $request['birthday_year'] . '-' . $request['birthday_month'] . '-' . $request['birthday_day'];
        }

        $request['code'] = md5(uniqid(rand(), true));

        return self::create($request);
    }

    public static function showUser($id)
    {
        return self::find($id);
    }

    public static function updateUser($id, $request)
    {
        $user = self::showUser($id);

        if ($request['birthday_year'] && $request['birthday_month'] && $request['birthday_day']) {
            $request['birthday'] = $request['birthday_year'] . '-' . $request['birthday_month'] . '-' . $request['birthday_day'];
        }

        return $user->update($request);
    }

    public static function acceptUser($code)
    {
        $user = self::where('code', '=', $code)->first();

        return $user->update([
            'status' => 1,
        ]);
    }

    public static function deleteUser($id)
    {
        $user = self::showUser($id);
        return $user->delete();
    }

    public static function checkExistsUser($email)
    {
        return self::where('email', $email)->exists();
    }

    public static function checkAcceptUser($email)
    {
        return self::where('email', $email)->where('status', '=', NOT_ACCEPT)->exists();
    }

    public static function searchUser($keyWord, $length)
    {
        if ($keyWord == '') {
            $user = User::orderBy('id', 'DESC')
                ->offset(0)
                ->limit(5)
                ->get();
        } else {
            $user = User::where('id', $keyWord)
                ->orWhere('name', 'like', '%' . $keyWord . '%')
                ->orWhere('email', 'like', '%' . $keyWord . '%')
                ->orWhere('social_id', 'like', '%' . $keyWord . '%')->get();
        }

        if ($length != '') {
            $user = User::orderBy('id', 'DESC')
                ->offset(0)
                ->limit($length)
                ->get();
        }
        return $user;
    }
}
