<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;
use Illuminate\Support\Facades\DB;

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

    private static function filter($params)
    {
        $user = new User();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $user = $user->where(function ($query) use ($keyword) {
                    $query->where('users.name', 'like', "%$keyword%")
                        ->orWhere('users.email', 'like', "%$keyword%");
                });
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $user = $user->whereRaw("users.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['status'])) {
            $status = $params['status'];

            $user = $user->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(users.status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(users.status = 1)");
                }
            });
        }

        if (isset($params['city'])) {
            $city = $params['city'];

            $user = $user->where(function ($query) use ($city) {
                $query->orWhereRaw("cities.code = ? ", [$city]);
            });
        }

        if (isset($params['city'])) {
            $city = $params['city'];

            $user = $user->where(function ($query) use ($city) {
                $query->orWhereRaw("cities.code = ? ", [$city]);
            });
        }

        if (isset($params['district'])) {
            $district = $params['district'];

            $user = $user->where(function ($query) use ($district) {
                $query->orWhereRaw("districts.code = ? ", [$district]);
            });
        }

        if (isset($params['district'])) {
            $district = $params['district'];

            $user = $user->where(function ($query) use ($district) {
                $query->orWhereRaw("districts.code = ? ", [$district]);
            });
        }

        return $user;
    }

    public static function getListAllUser($params = null)
    {
        $user = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "users.id DESC ";
        }
        return $user->select(
                'id', 'name', 'email',
                'phone', 'address', 'social_id',
                'avatar', 'status'
            )
            ->orderBy($order)->get();
    }

    public static function getAllUser($params = null)
    {
        $users = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "users.id desc";
        }
        $users = $users->whereNull('social_id')
            ->leftjoin('wards', 'wards.code', 'users.address')
            ->leftjoin('districts', 'wards.parent_code', 'districts.code')
            ->leftjoin('cities', 'districts.parent_code', 'cities.code')
            ->select(
                'users.id', 'users.name', 'users.email', 'users.created_at', 'users.address', 'users.gender',
                'users.phone', 'wards.path_with_type as address_user', 'users.birthday', 'users.status',
                'cities.code as cityId', 'districts.code as districtId'
            )
            ->orderByRaw($order)->paginate(LIMIT);

        return $users;
    }

    public static function getCountUSerBetweenFromTo($from, $to)
    {
        $users = self::whereNull('social_id')
            ->where('users.status', true)
            ->where('users.created_at', '>=', $from)
            ->where('users.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw('count(case when (users.status = 1) then 1 else null end) as countUser'),
                DB::raw("DATE_FORMAT(users.created_at, '%Y/%m') as month")
            )
            ->groupby('month')
            ->orderBy('month')
            ->get();

        $total = 0;
        foreach ($users as $user) {
            $total += $user['countUser'];
        }

        return $total;
    }

    public static function getCountUSerBetweenFromToMonth($from, $to)
    {
        $users = self::whereNull('social_id')
            ->where('users.status', true)
            ->where('users.created_at', '>=', $from)
            ->where('users.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw('count(case when (users.status = 1) then 1 else null end) as countUser'),
                DB::raw("DATE_FORMAT(users.created_at, '%Y/%m') month")
            )
            ->groupby('month')
            ->orderBy('month')
            ->get();

        $total = 0;
        foreach ($users as $user) {
            $total += $user['countUser'];
        }

        return $total;
    }

    public static function getAnalyticsUSerBetweenFromTo($from, $to)
    {
        $users = self::whereNull('social_id')
            ->where('users.status', true)
            ->where('users.created_at', '>=', $from)
            ->where('users.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw('count(case when (users.status = 1) then 1 else null end) as countUser'),
                DB::raw("DATE_FORMAT(users.created_at, '%Y/%m/%d') as date")
            )
            ->groupby('date')
            ->orderBy('date')
            ->pluck('countUser', 'date');
//            ->get()
//            ->toArray();

        $arrayDate = Helper::getArrayDateBetweenFromTo($from, $to);
        $analyticsUser = [];
        foreach ($arrayDate as $date) {
            $item = 0 . ',';
            foreach ($users as $key => $value) {
                if ($key == $date) {
                    $item = $value . ',';
                }
            }

            array_push($analyticsUser, $item);
        }

        return $analyticsUser;
    }

    public static function getAnalyticsUSerBetweenFromToMonth($from, $to)
    {
        $users = self::whereNull('social_id')
            ->where('users.status', true)
            ->where('users.created_at', '>=', $from)
            ->where('users.created_at', '<', date('Y/m/d', strtotime("+1 day", strtotime($to))))
            ->select(
                DB::raw('count(case when (users.status = 1) then 1 else null end) as countUser'),
                DB::raw("DATE_FORMAT(users.created_at, '%Y/%m') as month")
            )
            ->groupby('month')
            ->orderBy('month')
            ->pluck('countUser', 'month');
//            ->get()
//            ->toArray();

        $arrayDate = Helper::getArrayDateBetweenFromTo($from, $to);
        $analyticsUser = [];
        foreach ($arrayDate as $date) {
            $item = 0 . ',';
            foreach ($users as $key => $value) {
                if ($key == $date) {
                    $item = $value . ',';
                }
            }

            array_push($analyticsUser, $item);
        }

        return $analyticsUser;
    }

    public static function getCountUSer()
    {
        $users = self::whereNull('social_id')
            ->where('users.status', true)
            ->count();

        return $users;
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
