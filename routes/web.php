<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
});

Route::namespace('Backend')->group(function(){
    Route::group(['prefix' => 'admin'], function () {
//        Route::group(
//            ['prefix' => 'account'], function () {
//            Route::get('/edit_mail/confirm','ConfirmEmailController@editEmailStore')
//                ->name(ADMIN_NEW_UPDATE_MAIL_CONFIRM_ACCOUNT);
//        }
//        );
        Route::get('/login', 'LoginController@showLoginForm')
            ->name(ADMIN_SHOW_LOGIN);
        Route::post('/login', 'LoginController@login')
            ->name(ADMIN_LOGIN);
        Route::post('/logout', 'LoginController@logout')
            ->name(ADMIN_LOGOUT);
        Route::get('/forget_password', 'PasswordResetController@getForgetPassword')
            ->name(ADMIN_FORGET_PASSWORD);
        Route::post('/checkEmailAdmin', 'PasswordResetController@checkEmailAdmin');
        Route::post('/updatePassword', 'PasswordResetController@updatePasswordAjax');
    }
    );
    Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function(){
        Route::get('/', 'HomeController@index')->name(ADMIN_DASHBOARD);
        Route::get('/list', 'AdminController@index')->name(ADMIN_INDEX);
        Route::post('add', 'AdminController@store')->name(ADMIN_ADD);
        Route::post('edit/{id}', 'AdminController@update')->name(ADMIN_EDIT);
        Route::delete('delete/{id}', 'AdminController@delete')->name(ADMIN_DELETE);
        Route::get('/list_admin', 'AdminController@getListAdmin');
        Route::delete('/destroy', 'AdminController@destroy');

        Route::group(['prefix' => 'category'], function(){
            Route::get('/', 'CategoryController@index')->name(ADMIN_CATEGORY_INDEX);
            Route::post('add', 'CategoryController@store')->name(ADMIN_CATEGORY_ADD);
            Route::post('edit/{id}', 'CategoryController@update')->name(ADMIN_CATEGORY_EDIT);
            Route::delete('delete/{id}', 'CategoryController@delete')->name(ADMIN_CATEGORY_DELETE);
            Route::get('/list-category', 'CategoryController@getListCategory');
            Route::delete('/destroy', 'CategoryController@destroy');
            Route::post('checkValidate', 'CategoryController@checkValidate');
        });

        Route::group(['prefix' => 'product_category'], function(){
            Route::get('/', 'ProductCategoryController@index')->name(ADMIN_PRODUCT_CATEGORY_INDEX);
            Route::post('add', 'ProductCategoryController@store')->name(ADMIN_PRODUCT_CATEGORY_ADD);
            Route::post('edit/{id}', 'ProductCategoryController@update')->name(ADMIN_PRODUCT_CATEGORY_EDIT);
            Route::delete('delete/{id}', 'ProductCategoryController@delete')->name(ADMIN_PRODUCT_CATEGORY_DELETE);
            Route::get('/list_product_category', 'ProductCategoryController@getListProductCategory');
            Route::delete('/destroy', 'ProductCategoryController@destroy');
        });

        Route::group(['prefix' => 'product_type'], function(){
            Route::get('/', 'ProductTypeController@index')->name(ADMIN_PRODUCT_TYPE_INDEX);
            Route::post('add', 'ProductTypeController@store')->name(ADMIN_PRODUCT_TYPE_ADD);
            Route::post('edit/{id}', 'ProductTypeController@update')->name(ADMIN_PRODUCT_TYPE_EDIT);
            Route::delete('delete/{id}', 'ProductTypeController@delete')->name(ADMIN_PRODUCT_TYPE_DELETE);
            Route::get('/list_product_type', 'ProductTypeController@getListProductType');
            Route::delete('/destroy', 'ProductTypeController@destroy');
        });

        Route::group(['prefix' => 'product'], function(){
            Route::get('/', 'ProductController@index')->name(ADMIN_PRODUCT_INDEX);
            Route::get('create', 'ProductController@create')->name(ADMIN_PRODUCT_ADD_INDEX);
            Route::post('add', 'ProductController@store')->name(ADMIN_PRODUCT_ADD);
            Route::post('edit/{id}', 'ProductController@update')->name(ADMIN_PRODUCT_EDIT);
            Route::delete('delete/{id}', 'ProductController@delete')->name(ADMIN_PRODUCT_DELETE);
            Route::get('/list_product', 'ProductController@getListProduct');
            Route::delete('/destroy', 'ProductController@destroy');
            Route::post('uploadImages', 'ProductController@uploadImages');
            Route::get('getImages', 'ProductController@getImages');
            Route::post('deleteImages', 'ProductController@deleteImages');
        });

        Route::group(['prefix' => 'ajax'], function(){
            Route::get('/list_product_category', 'AjaxController@getProductCategory');
            Route::get('/listProductType', 'AjaxController@getProductType');
        });
    });
});


Route::namespace('FrontEnd')->group(function(){
    Route::group(['prefix' => 'home'], function(){
        Route::get('/', 'HomeController@index')
            ->name(FRONT_END_HOME_INDEX);
    });
});
