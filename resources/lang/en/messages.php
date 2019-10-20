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
    'login' => [
        'login_success' => 'Login successfully.',
        'login_failed' => 'Login failed. Please re-enter your account.',
        'login_admin' => 'Please enter your account.',
        'logout_success' => 'Log out successfully.',
        'required' => ':attribute cannot be left blank.',
        'email' => ':attribute invalidate.',
        'password' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be 8 characters.',
            'regex' => ':attribute must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.'
        ],
    ],

    'admin' => [
        'create_success' => 'Successfully add new admin.',
        'create_failed' => 'Unsuccessfully add new admin.',
        'update_success' => 'Successfully edit admin.',
        'update_failed' => 'Unsuccessfully edit admin.',
        'delete_success' => 'Successfully delete admin.',
        'delete_failed' => 'Unsuccessfully delete admin.',
        'login_success' => 'Login successfully.',
        'login_failed' => 'Login failed. Please re-enter your account.',
        'login_admin' => 'Please enter your account.',
        'logout_success' => 'Log out successfully.',
        'password_reset' => [
            'email' => [
                'required' => 'Email cannot be left blank.',
                'not_exists' => 'Email not exists.'
            ],
            'required' => ':attribute cannot be left blank.',
            'password' => [
                'required' => ':attribute cannot be left blank.',
                'min' => ':attribute must be 8 characters.',
                'regex' => ':attribute must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.'
            ],
            'confirm_password' => [
                'required_with' => 'Please enter confirm the new password.',
                'same' => 'Retype password does not match new password entered.'
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
        'admin_group_id' => [
            'required' => 'Please select an admin permission.',
        ],
    ],

    'category' => [
        'create_success' => 'Successfully add new category.',
        'create_failed' => 'Unsuccessfully add new category.',
        'update_success' => 'Successfully edit category.',
        'update_failed' => 'Unsuccessfully edit category.',
        'delete_success' => 'Successfully delete category.',
        'delete_failed' => 'Unsuccessfully delete category.',
        'name' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be between 3-100 characters.',
            'max' => ':attribute must be between 3-100 characters.',
            'unique' => ':attribute was used in the database.',
        ],
        'order' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be greater than or equal to 0.',
            'numeric' => ':attribute must be numeric format.',
        ],
    ],

    'product_category' => [
        'create_success' => 'Successfully add new product category.',
        'create_failed' => 'Unsuccessfully add new  product category.',
        'update_success' => 'Successfully edit  product category.',
        'update_failed' => 'Unsuccessfully edit  product category.',
        'delete_success' => 'Successfully delete  product category.',
        'delete_failed' => 'Unsuccessfully delete  product category.',
        'name' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be between 3-100 characters.',
            'max' => ':attribute must be between 3-100 characters.',
            'unique' => ':attribute was used in the database.',
        ],
        'category_id' => [
            'required' => 'Please select a category.',
        ],
    ],

    'product_type' => [
        'create_success' => 'Successfully add new product type.',
        'create_failed' => 'Unsuccessfully add new  product type.',
        'update_success' => 'Successfully edit  product type.',
        'update_failed' => 'Unsuccessfully edit  product type.',
        'delete_success' => 'Successfully delete  product type.',
        'delete_failed' => 'Unsuccessfully delete  product type.',
        'name' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be between 3-100 characters.',
            'max' => ':attribute must be between 3-100 characters.',
            'unique' => ':attribute was used in the database.',
        ],
        'category_id' => [
            'required' => 'Please select a category.',
        ],
        'product_category_id' => [
            'required' => 'Please select a product category.',
        ],
    ],

    'product' => [
        'create_success' => 'Successfully add new product.',
        'create_failed' => 'Unsuccessfully add new  product.',
        'update_success' => 'Successfully edit  product.',
        'update_failed' => 'Unsuccessfully edit  product.',
        'delete_success' => 'Successfully delete  product.',
        'delete_failed' => 'Unsuccessfully delete  product.',
        'numeric' => ':attribute must be numeric.',
        'image' => ':attribute must be an image file.',
        'name' => [
            'required' => ':attribute cannot be left blank.',
            'min' => ':attribute must be between 5-100 characters.',
            'max' => ':attribute must be between 5-100 characters.',
            'unique' => ':attribute was used in the database.',
        ],
        'category_id' => [
            'required' => 'Please select a category.',
        ],
        'product_category_id' => [
            'required' => 'Please select a product category.',
        ],
        'product_type_id' => [
            'required' => 'Please select a product type.',
        ],
        'product_price' => [
            'more' => 'Please enter a product price greater than the promotion price.',
        ],
        'product_promotional' => [
            'less' => 'Please enter promotion price less than product price.',
        ],
        'product_description' => [
            'min' => ':attribute must be 20 characters.',
            'max' => ':attribute must be at most 255 characters.',
            'less' => 'Please enter promotion price less than product price.',
        ],
        'product_content' => [
            'min' => ':attribute must be 50 characters.',
        ],
    ],
];
