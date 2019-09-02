<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the admin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function viewAdmin(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can create admins.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function createAdmin(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can update the admin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function updateAdmin(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the admin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function deleteAdmin(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the admin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function restoreAdmin(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the admin.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Admin  $admin
     * @return mixed
     */
    public function forceDeleteAdmin(Admin $admin)
    {
        return false;
    }
}
