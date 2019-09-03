<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPasswordReset extends Model
{
    /**
     * @var string
     */
    protected $table = 'admin_password_resets';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Delete admin password reset by email
     *
     * @param $email
     */
    public static function deleteAdminPasswordResetByEmail($email)
    {
        AdminPasswordReset::where('email', $email)->delete();
    }
}
