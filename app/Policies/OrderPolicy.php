<?php

namespace App\Policies;

use App\Models\Admin;
use App\ProductType;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function viewOrder(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create Order types.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function createOrder(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the Order type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function updateOrder(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the Order type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function deleteOrder(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the Order type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function restoreOrder(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the Order type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function forceDeleteOrder(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }
}
