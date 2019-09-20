<?php

namespace App\Policies;

use App\Models\Admin;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the category.
     *
     * @param  Admin  $admin
     * @return mixed
     */
    public function viewCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
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
    public function createCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY])) {
            return true;
        }

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
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY])) {
            return true;
        }

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
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY])) {
            return true;
        }

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
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY])) {
            return true;
        }

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
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY])) {
            return true;
        }

        return false;
    }
}
