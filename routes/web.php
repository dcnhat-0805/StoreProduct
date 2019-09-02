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
    return view('welcome');
});

Route::group(
    ['prefix' => 'admin', 'namespace' => 'Backend'],
    function () {
//        Route::get('/login_password_reset', 'PasswordResetController@index')
//            ->name(ADMIN_NEW_FORGOT_PASSWORD);
//        Route::group(
//            ['prefix' => 'account'], function () {
//            Route::get('/edit_mail/confirm','ConfirmEmailController@editEmailStore')
//                ->name(ADMIN_NEW_UPDATE_MAIL_CONFIRM_ACCOUNT);
//        }
//        );
        Route::get('/login', 'AdminController@showLoginForm')
            ->name(ADMIN_SHOW_LOGIN);
        Route::post('/login', 'AdminController@login')
            ->name(ADMIN_LOGIN);
        Route::post('/logout', 'AdminController@logout')
            ->name(ADMIN_LOGOUT);
    }
);
Route::namespace('Backend')->group(function(){
    Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function(){
        Route::get('/', 'HomeController@index')->name(ADMIN_DASHBOARD);
        Route::get('/list', 'AdminController@index')->name(ADMIN_INDEX);
        Route::post('add', 'AdminController@store')->name(ADMIN_ADD);
        Route::post('edit/{id}', 'AdminController@update')->name(ADMIN_EDIT);
        Route::delete('delete/{id}', 'AdminController@delete')->name(ADMIN_DELETE);

        Route::group(['prefix' => 'category'], function(){
            Route::get('/', 'CategoryController@index')->name(ADMIN_CATEGORY_INDEX);
            Route::post('add', 'CategoryController@store')->name(ADMIN_CATEGORY_ADD);
        });
    });
});
