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

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Backend')->group(function(){
    Route::group(['prefix' => 'admin'], function(){
        Route::get('/', 'HomeController@index')->name(ADMIN_DASHBOARD);

        Route::group(['prefix' => 'category'], function(){
            Route::get('/', 'CategoryController@index')->name(ADMIN_CATEGORY_INDEX);
            Route::post('add', 'CategoryController@store')->name(ADMIN_CATEGORY_ADD);
        });
    });
});
