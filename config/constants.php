<?php
/**
 * Defind Constants Variables
 *
 * @category  Config\Constants
 * @package   Config\Constants
 * @author    Duong Cong Nhat <nhat605117@student.vnua.edu.vn>
 * @copyright 2018 store online
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://laravel.com Laravel(tm) Project
 */

const ADMIN_DASHBOARD = 'admin.dashboard';

const ADMIN_SHOW_LOGIN = 'login';
const ADMIN_LOGIN = 'admin.login';
const ADMIN_LOGOUT = 'admin.logout';
const ADMIN_FORGET_PASSWORD = 'admin.forget.password';

const ADMIN_CATEGORY_INDEX = 'admin.category.index';
const ADMIN_CATEGORY_ADD = 'admin.category.add';
const ADMIN_CATEGORY_EDIT = 'admin.category.edit';
const ADMIN_CATEGORY_DELETE = 'admin.category.delete';

const ADMIN_PRODUCT_CATEGORY_INDEX = 'admin.product.category.index';
const ADMIN_PRODUCT_CATEGORY_ADD = 'admin.product.category.add';
const ADMIN_PRODUCT_CATEGORY_EDIT = 'admin.product.category.edit';
const ADMIN_PRODUCT_CATEGORY_DELETE = 'admin.product.category.delete';

const ADMIN_PRODUCT_TYPE_INDEX = 'admin.product.type.index';
const ADMIN_PRODUCT_TYPE_ADD = 'admin.product.type.add';
const ADMIN_PRODUCT_TYPE_EDIT = 'admin.product.type.edit';
const ADMIN_PRODUCT_TYPE_DELETE = 'admin.product.type.delete';

const ADMIN_PRODUCT_INDEX = 'admin.product.index';
const ADMIN_PRODUCT_ADD = 'admin.product.add';
const ADMIN_PRODUCT_ADD_INDEX = 'admin.product.add.index';
const ADMIN_PRODUCT_EDIT = 'admin.product.edit';
const ADMIN_PRODUCT_DELETE = 'admin.product.delete';

const ADMIN_INDEX = 'admin.list';
const ADMIN_INDEX_BLADE = 'backend.pages.admin.index';
const ADMIN_ADD = 'admin.add';
const ADMIN_EDIT = 'admin.edit';
const ADMIN_DELETE = 'admin.delete';

const EMAIL_FORM = 'store.online.232@gmail.com';
const EMAIL_NAME = 'StoreOnline';
const EMAIL_SUBJECT_PREFIX = '';
const EMAIL_SUBJECT = 'Thông báo về khóa xác thực đặt lại mật khẩu';

const LIMIT = 5;

const ADMIN = 1;
const CATEGORY = 2;
const PRODUCT_CATEGORY = 3;
const PRODUCT_TYPE = 4;
const PRODUCT = 5;
const ADMIN_PERMISSION = [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT];

const DELETE_ALL = 1;

const SORT_PARAMS_ALLOWED = [
    'id' => 'id',
];

const FRONT_END_HOME_INDEX = 'front.end.home.index';

const SESSION_REMEMBER_TOKEN = 'ss.remember.token';
