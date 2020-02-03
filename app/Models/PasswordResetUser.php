<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetUser extends Model
{
    /**
     * @var string
     */
    protected $table = 'password_reset_users';

    /**
     * @var array
     */
    protected $guarded = [];

    public static function deleteUserPasswordResetByEmail($email)
    {
        return self::where('email', $email)->delete();
    }
}
