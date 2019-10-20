<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class CheckPriceProduct implements Rule
{
    protected $price;
    protected $promotional;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($price, $promotional)
    {
        $this->price = $price;
        $this->promotional = $promotional;
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
        if (empty($this->price) && empty($this->promotional)) {
            return false;
        }

        if (!empty($this->price) && empty($this->promotional)) {
            return true;
        }

        if ($this->price < $this->promotional) {
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
        if ($this->price < $this->promotional) {
            return trans("messages.product.product_price.more");
        }
    }
}
