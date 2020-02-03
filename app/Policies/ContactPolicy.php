<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Comment.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewContact(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function createContact(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the Comment.
     *
     * @param  Admin  $admin
     *
     * @return mixed
     */
    public function updateContact(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the Comment.
     *
     * @param  Admin  $admin
     *
     * @return mixed
     */
    public function deleteContact(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the Comment.
     *
     * @param  Admin  $admin
     *
     * @return mixed
     */
    public function restoreContact(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the Comment.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function forceDeleteContact(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }
}
