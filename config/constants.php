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
const ADMIN_PRODUCT_UPDATE = 'admin.product.update';
const ADMIN_PRODUCT_DELETE = 'admin.product.delete';

const ADMIN_INDEX = 'admin.list';
const ADMIN_INDEX_BLADE = 'backend.pages.admin.index';
const ADMIN_ADD = 'admin.add';
const ADMIN_EDIT = 'admin.edit';
const ADMIN_DELETE = 'admin.delete';

const EMAIL_FORM = 'store.online.232@gmail.com';
const EMAIL_NAME = 'StoreOnline';
const EMAIL_SUBJECT_PREFIX = '';
const EMAIL_SUBJECT = '[StoreOnline] Please reset your password !';

const LIMIT = 2;
const FRONT_LIMIT = 3;

const ADMIN = 1;
const CATEGORY = 2;
const PRODUCT_CATEGORY = 3;
const PRODUCT_TYPE = 4;
const PRODUCT = 5;
const ADMIN_PERMISSION = [ADMIN, CATEGORY, PRODUCT_CATEGORY, PRODUCT_TYPE, PRODUCT];

const DELETE_ALL = 1;

const PERMISSION = [
    '' => 'Please select an admin permission',
    1 => 'System Management',
    2 => 'Category',
    3 => 'Product Category',
    4 => 'Product Type',
    5 => 'Product',
];

const SORT_PARAMS_ALLOWED = [
    'id' => 'id',
];

const FRONT_END_HOME_INDEX = 'front.end.home.index';
const FRONT_PRODUCT_LIST = 'front.end.product.category.index';
const FRONT_CART_INDEX = 'front.end.cart.index';
const FRONT_ADD_CART = 'front.end.add.cart';

const SESSION_REMEMBER_TOKEN = 'ss.remember.token';

const PREFIX_PRODUCT = 'product';
const PREFIX_PRODUCT_DETAIL = 'product-detail';
const FILE_PATH_PRODUCT = 'backend/images/uploads/product/';
const FILE_PATH_PRODUCT_IMAGE = 'backend/images/uploads/product/detail/';

const SESSION_PRODUCT_IMAGE = 'ss.product.image';
const SESSION_LIST_PRODUCT_IMAGE = 'ss.list.product.image';
const IMAGE_RESIZE_WIDTH = 320;
const IMAGE_RESIZE_HEIGHT = 240;
const IMAGE_RESIZE_PREFIX = 'resize-';
