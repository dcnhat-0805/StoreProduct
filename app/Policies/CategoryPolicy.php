<?php

namespace App\Policies;

use App\Models\Admin;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function before(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY])) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the category.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewCategory(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function createCategory(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param  Admin  $admin
     *
     * @return mixed
     */
    public function updateCategory(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param  Admin  $admin
     *
     * @return mixed
     */
    public function deleteCategory(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the category.
     *
     * @param  Admin  $admin
     *
     * @return mixed
     */
    public function restoreCategory(Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the category.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function forceDeleteCategory(Admin $admin)
    {
        return false;
    }
}
