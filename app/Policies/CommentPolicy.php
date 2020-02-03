<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the Comment.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewComment(Admin $admin)
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
    public function createComment(Admin $admin)
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
    public function updateComment(Admin $admin)
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
    public function deleteComment(Admin $admin)
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
    public function restoreComment(Admin $admin)
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
    public function forceDeleteComment(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN])) {
            return true;
        }

        return false;
    }
}
