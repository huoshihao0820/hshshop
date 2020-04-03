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
Route::get('/login/login','Admin\LoginController@login');
Route::post('/login/login_do','Admin\LoginController@login_do');
Route::get('/login/register','Admin\LoginController@register');
Route::post('/login/register_do','Admin\LoginController@register_do');
Route::any('/login/wechatout','Admin\LoginController@wechatout');
Route::any('/login/img','Admin\LoginController@img');
Route::any('/login/log','Admin\LoginController@log');
Route::any('/login/show','Admin\LoginController@show');
Route::any('/login/bd','Admin\LoginController@bd');
Route::any('/login/wechat','Admin\LoginController@wechat');
Route::any('/login/send','Admin\LoginController@send');

Route::prefix('/student')->middleware('checklogin')->group(function () {
    Route::any('/show', 'StudentController@show');
//    Route::any('/toupiao', 'StudentController@toupiao');
    Route::get('/add', 'StudentController@add');
    Route::post('/add_do', 'StudentController@add_do');
    Route::get('/update/{id}', 'StudentController@update');
    Route::post('/update_do/{id}', 'StudentController@update_do');
    Route::get('/delete/{id}', 'StudentController@delete');

});

Route::prefix('/index')->group(function () {
    Route::any('/index', 'Admin\IndexController@index');

});
//->middleware('checklogin')

Route::prefix('brand')->middleware('checklogin')->group(function () {
    Route::any('/show', 'Admin\BrandController@show');
    Route::any('/toupiao', 'Admin\BrandController@toupiao');
    Route::get('/add', 'Admin\BrandController@add');
    Route::post('/add_do', 'Admin\BrandController@add_do');
    Route::post('/tp', 'Admin\BrandController@tp');
    Route::get('/update/{id}', 'Admin\BrandController@update');
    Route::any('/update_do/{id}', 'Admin\BrandController@update_do');
    Route::get('/delete/{id}', 'Admin\BrandController@delete');
    Route::any('/del', 'Admin\BrandController@del');
    Route::any('/checkname', 'Admin\BrandController@checkname');
});

