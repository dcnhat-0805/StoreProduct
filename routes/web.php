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

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function(){
    Route::get('index', 'HomeController@index');

    Route::group(['prefix' => 'category'], function(){
        Route::get('list', 'CategoryController@index');
        Route::post('add', 'CategoryController@store');
    });
});
