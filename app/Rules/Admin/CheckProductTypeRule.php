<?php

namespace App\Rules\Admin;

use App\Models\ProductType;
use Illuminate\Contracts\Validation\Rule;

class CheckProductTypeRule implements Rule
{
    protected $productCategoryId;
    protected $productTypeId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($productCategoryId, $productTypeId)
    {
        $this->productCategoryId = $productCategoryId;
        $this->productTypeId = $productTypeId;
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

        if ($productType && empty($this->productTypeId)) {
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
