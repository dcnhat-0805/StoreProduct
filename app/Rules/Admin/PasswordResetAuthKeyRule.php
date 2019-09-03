<?php
/**
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 7.1
 *
 * @category  Rule
 * @package   App\Rules
 * @author    Chu Hoai Linh <linhch@deha-soft.com>
 * @copyright 2018 kyujin
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://laravel.com Laravel(tm) Project
 */
namespace App\Rules\Admin;

use App\Models\AdminPasswordReset;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class PasswordResetAuthKeyRule
 *
 * @category  Rule
 * @package   App\Rules
 * @author    Chu Hoai Linh <linhch@deha-soft.com>
 * @copyright 2018 kyujin
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://laravel.com Laravel(tm) Project
 */
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
        return 'Mã xác thực sai.';
    }
}
