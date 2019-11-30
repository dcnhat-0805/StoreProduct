<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the admin.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewCustomer(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
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
    public function createCustomer(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
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
    public function updateCustomer(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
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
    public function deleteCustomer(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
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
    public function restoreCustomer(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
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
    public function forceDeleteCustomer(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }
}
