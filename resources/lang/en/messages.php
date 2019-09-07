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
        'create_success' => 'Đăng ký thành công người quản trị mới.',
        'update_success' => 'Cập nhật thành công người quản trị.',
        'delete_success' => 'Xóa thành công người quản trị.',
        'delete_failed' => 'Xóa không thành công người quản trị.',
        'login_success' => 'Đăng nhập thành công.',
        'login_failed' => 'Đăng nhập thất bại.',
        'logout_success' => 'Đăng xuất thành công.',
        'password_reset' => [
            'email' => [
                'required' => 'Email không được để trống.',
                'not_exists' => 'Email không tồn tại.'
            ],
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
