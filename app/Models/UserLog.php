<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserLog extends Model
{

    protected $table = 'user_logs';

    /**
     * Save data
     *
     * @param string $message  message login
     * @param string $username username
     *
     * @return void
     */
    public function saveData($message, $username)
    {

        $this->admin_id = Auth::guard("admins")->id();
        if (Auth::user() != null) {
            $this->user_id = Auth::user()->id;
        }
        $this->message = $message;
        $this->username = $username;

        $this->save();
    }
}
