<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserLog extends Model
{

    protected $table = 'user_logs';

    protected $fillable = ['admin_id', 'user_id', 'username', 'message'];

    /**
     * Save data
     *
     * @param string $message  message login
     * @param string $username username
     *
     * @return void
     */
    public static function saveAdminLog($message, $username)
    {
        $useLog = UserLog::create([
            'admin_id' => (Auth::guard("admins") != null) ? Auth::guard("admins")->id() : null,
            'user_id' => null,
            'message' => $message,
            'username' => $username,
        ]);

        $useLog->save();
    }

    public static function saveUserLog($message, $username)
    {
        $useLog = UserLog::create([
            'admin_id' => null,
            'user_id' => (Auth::user() != null) ? Auth::user()->id : null,
            'message' => $message,
            'username' => $username,
        ]);

        $useLog->save();
    }
}
