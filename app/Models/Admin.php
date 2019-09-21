<?php

namespace App\Models;

use App\Helpers\Helper;
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

    private static function filter($params)
    {
        $admin = new Admin();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $admin = $admin->where('admins.name', 'like', "%$keyword%")
                    ->orWhere('admins.email', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $admin = $admin->whereRaw("admins.created_at BETWEEN ? AND ?", [$publishDate[0], date('Y/m/d', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        if (isset($params['admin_group_id'])) {
            $admin_gropu_id = $params['admin_group_id'];
            if ($admin_gropu_id != 0) {
                $admin = $admin->whereIn('admin_groups.id', explode(',', $admin_gropu_id));
            }
        }


        if (isset($params['status'])) {
            $status = $params['status'];

            $admin = $admin->where(function ($query) use ($status) {
                if (in_array(0, $status)) {
                    $query->orWhereRaw("(admins.admin_status = 0)");
                }
                if (in_array(1, $status)) {
                    $query->orWhereRaw("(admins.admin_status = 1)");
                }
            });
        }

        return $admin;
    }

    public static function getListAllAdmin($params = null)
    {
        $admin = self::filter($params);
        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "id DESC ";
        }
        $now = date('Y-m-d');
        $admin = $admin->whereNull('admins.deleted_at')
            ->whereNull('admin_groups.deleted_at')
            ->join('admin_groups', 'admins.admin_group_id', 'admin_groups.id')
            ->selectRaw("admins.*")
            ->with('adminGroup')
            ->groupBy('admins.id')
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $admin;
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
