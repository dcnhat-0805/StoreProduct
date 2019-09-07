<?php
/**
 * Convert messages to jp
 *
 * PHP Version 7.2
 *
 * @category Lang\jp
 * @package  Lang\jp
 * @author   Duong Cong Nhat <nhat.dc@deha-soft.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://laravel.com/
 */

return [
    'admin' => [
        'create_success' => 'Successfully add new admin.',
        'create_failed' => 'Unsuccessfully add new admin.',
        'update_success' => 'Successfully edit admin.',
        'update_failed' => 'Unsuccessfully edit admin.',
        'delete_success' => 'Successfully delete admin.',
        'delete_failed' => 'Unsuccessfully delete admin.',
        'login_success' => 'Login successfully.',
        'login_failed' => 'Login failed.',
        'logout_success' => 'Log out successfully.',
        'password_reset' => [
            'email' => [
                'required' => 'Email cannot be left blank.',
                'not_exists' => 'Email not exists.'
            ],
        ],
        'name' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be between 5-50 characters.',
            'max' => ':attribute must be between 5-50 characters.',
            'unique' => ':attribute was used in the database.',
        ],
        'email' => [
            'required' => ':attribute cannot be left blank.',
            'unique' => ':attribute was used in the database.',
            'email_format' => 'The format of the email address is incorrect.',
        ],
        'password' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be at least 8 characters.',
            'regex' => ' must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.'
        ],
        'confirm_password' => [
            'required' => ':attribute cannot be left blank.',
            'same' => ':attribute does not match the password entered.',
        ],
    ],

    'category' => [
        'create_success' => 'Successfully add new category.',
        'create_failed' => 'Unsuccessfully add new category.',
        'update_success' => 'Successfully edit category.',
        'update_failed' => 'Unsuccessfully edit category.',
        'delete_success' => 'Successfully delete category.',
        'delete_failed' => 'Unsuccessfully delete new category.',
        'name' => [
            'required' => 'cannot be left blank.',
            'min' => 'must be between 3-100 characters.',
            'max' => 'must be between 3-100 characters.',
            'unique' => 'was used in the database.',
        ],
        'order' => [
            'min' => 'must be greater than or equal to 0.',
            'numeric' => 'must be numeric format.',
        ],
    ]
];
