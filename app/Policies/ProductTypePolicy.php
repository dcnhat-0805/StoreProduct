<?php

namespace App\Policies;

use App\Models\Admin;
use App\ProductType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product type.
     *
     * @param  Admin $admin
     * @return mixed
     */
    public function viewProductType(Admin $admin)
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
    public function createProductType(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE])) {
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
    public function updateProductType(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE])) {
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
    public function deleteProductType(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE])) {
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
    public function restoreProductType(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE])) {
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
    public function forceDeleteProductType(Admin $admin)
    {
        if (in_array($admin->role, [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE])) {
            return true;
        }

        return false;
    }
}
