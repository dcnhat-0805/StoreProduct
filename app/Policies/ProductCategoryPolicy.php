<?php

namespace App\Policies;

use App\Models\Admin;
use App\ProductCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product category.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function viewProductCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create product categories.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function createProductCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the product category.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function updateProductCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the product category.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function deleteProductCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the product category.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function restoreProductCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the product category.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function forceDeleteProductCategory(Admin $admin)
    {
        if (in_array($admin->adminGroup->permission, [ADMIN, CATEGORY, PRODUCT_CATEGORY])) {
            return true;
        }

        return false;
    }
}
