<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class MinLengthTextArea implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $minLength;
    private $message;

    public function __construct($minLength, $message)
    {
        $this->minLength = $minLength;
        $this->message = $message;
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
        $length = strlen(iconv('utf-8', 'utf-16le', preg_replace ('/\r\n/', 'n', $value))) / 2;

        return $length >= $this->minLength;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
