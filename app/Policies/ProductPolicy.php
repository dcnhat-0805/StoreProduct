<?php

namespace App\Policies;

use App\Models\Admin;
use App\ProductType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function viewProduct(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create product types.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function createProduct(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function updateProduct(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function deleteProduct(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function restoreProduct(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function forceDeleteProduct(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT])) {
            return true;
        }

        return false;
    }
}
