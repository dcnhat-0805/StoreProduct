<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'name', 'email', 'password',
        'phone', 'address', 'social_id',
        'avatar', 'status'
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

    public function getListAllUser()
    {
        return $this->select(
                'name', 'email', 'password',
                'phone', 'address', 'social_id',
                'avatar', 'status'
            )
            ->orderBy('id', 'DESC')->get();
    }

    public function getListUser()
    {
        return $this->select(
            'name', 'email', 'password',
            'phone', 'address', 'social_id',
            'avatar', 'status'
        )
            ->orderBy('id', 'DESC')->paginate(5);
    }

    public function createUser($request)
    {
        if ($request['password'] !== '') {
            $request['password'] = Hash::make($request['password']);
        }
        return $this->create($request);
    }

    public function showUser($id)
    {
        return $this->find($id);
    }

    public function updateUser($id, $request)
    {
        $user = $this->showUser($id);
        return $user->update($request);
    }

    public function deleteUser($id)
    {
        $user = $this->showUser($id);
        return $user->delete();
    }

    public function searchUser($keyWord, $length)
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
