<?php
namespace App\Rules\Admin;

use App\Models\AdminPasswordReset;
use Illuminate\Contracts\Validation\Rule;

class PasswordResetAuthKeyRule implements Rule
{
    /**
     * @var
     */
    protected $email;

    /**
     * Create a new rule instance.
     *
     * @param $email
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passwordReset = AdminPasswordReset::where('email', $this->email)
            ->where('token', $value)
            ->where('updated_at', '>', date('Y-m-d H:i:s', strtotime('-30 minutes')))
            ->first();
        if (!$passwordReset) {
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
        return 'The verification code entered is not correct.';
    }
}
