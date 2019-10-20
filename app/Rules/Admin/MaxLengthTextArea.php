<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class MaxLengthTextArea implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $maxLength;
    private $message;

    public function __construct($maxLength, $message)
    {
        $this->maxLength = $maxLength;
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

        return $length <= $this->maxLength;
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
