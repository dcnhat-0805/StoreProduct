<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the admin.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewAdmin(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create admins.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function createAdmin(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the admin.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function updateAdmin(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the admin.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function deleteAdmin(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the admin.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function restoreAdmin(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the admin.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function forceDeleteAdmin(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN])) {
            return true;
        }

        return false;
    }
}
