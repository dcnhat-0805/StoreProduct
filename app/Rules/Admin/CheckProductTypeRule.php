<?php

namespace App\Rules\Admin;

use App\Models\ProductType;
use Illuminate\Contracts\Validation\Rule;

class CheckProductTypeRule implements Rule
{
    protected $productCategoryId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($productCategoryId)
    {
        $this->productCategoryId = $productCategoryId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $productType = ProductType::where('product_category_id', '=', $this->productCategoryId)->get();

        if ($productType) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("messages.product.product_type_id.required");
    }
}
