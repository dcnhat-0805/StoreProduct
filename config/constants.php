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
const EMAIL_SUBJECT_PREFIX_USER = '';
const EMAIL_SUBJECT = '[StoreOnline] Please reset your password !';
const EMAIL_SUBJECT_USER = '[StoreOnline] Confirm your account on StoreOnline !';
const EMAIL_SUBJECT_SHOPPING = '[StoreOnline] Notice of successful orders !';

const LIMIT = 10;
const FRONT_LIMIT = 25;

const ACCEPT = 1;
const NOT_ACCEPT = 0;

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
const FRONT_PRODUCT_LIST = 'front.end.product.index';
const FRONT_PRODUCT_DETAIL = 'front.end.product.detail';
const FRONT_CART_INDEX = 'front.end.cart.index';
const FRONT_ADD_CART = 'front.end.add.cart';
const FRONT_UPDATE_CART = 'front.end.update.cart';
const FRONT_CHECK_COUNT_CART = 'front.end.check.count.cart';
const FRONT_PURCHASE = 'front.end.purchase';
const FRONT_SHOPPING_CART = 'front.end.shopping.cart';

const FRONT_LOGIN = 'front.end.show.form.login';
const FRONT_END_LOGIN = 'front.end.login';
const FRONT_LOGOUT = 'front.end.logout';
const FRONT_REGISTER = 'front.end.register';
const FRONT_STORE = 'front.end.store';
const FRONT_ACCEPT = 'front.end.accept';
const FRONT_LOGIN_SOCIALITE = 'front.end.login.facebook';
const FRONT_FORGET_PASSWORD = 'front.end.forget.password';

const SESSION_REMEMBER_TOKEN = 'ss.remember.token';

const SESSION_ROW_IDS = 'ss.row.ids';

const PREFIX_PRODUCT = 'product';
const PREFIX_PRODUCT_DETAIL = 'product-detail';
const FILE_PATH_PRODUCT = 'backend/images/uploads/product/';
const FILE_PATH_PRODUCT_IMAGE = 'backend/images/uploads/product/detail/';

const SESSION_PRODUCT_IMAGE = 'ss.product.image';
const SESSION_LIST_PRODUCT_IMAGE = 'ss.list.product.image';
const IMAGE_RESIZE_WIDTH = 320;
const IMAGE_RESIZE_HEIGHT = 240;
const IMAGE_RESIZE_PREFIX = 'product-';

const PRODUCT_ATTRIBUTE = [
    '' => 'Please select a product attribute',
    '1' => 'Color',
    '2' => 'Storage',
    '3' => 'Size',
    '4' => 'Materials',
];

const MONTH = [
    '' => 'Month',
    'January' => 'January',
    'February' => 'February',
    'March' => 'March',
    'April' => 'April',
    'May' => 'May',
    'June' => 'June',
    'July' => 'July',
    'August' => 'August',
    'September' => 'September',
    'October' => 'October',
    'November' => 'November',
    'December' => 'December',
];

const DAY = [
    '' => 'Day',
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    10 => 10,
    11 => 11,
    12 => 12,
    13 => 13,
    14 => 14,
    15 => 15,
    16 => 16,
    17 => 17,
    18 => 18,
    19 => 19,
    20 => 20,
    21 => 21,
    22 => 22,
    23 => 23,
    24 => 24,
    25 => 25,
    26 => 26,
    27 => 27,
    28 => 28,
    29 => 29,
    30 => 30,
    31 => 31,
];

const COLOR = 1;
const STORAGE = 2;
const SIZE = 3;
const MATERIALS = 4;

const BEST = 1;
const NEWS = 2;
const HOT = 3;
const PROMOTION = 4;
