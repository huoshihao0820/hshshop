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
Route::get('/login/wechatout','Admin\LoginController@wechatout');

Route::prefix('/student')->group(function () {
    Route::any('/show', 'StudentController@show');
    Route::get('/add', 'StudentController@add');
    Route::post('/add_do', 'StudentController@add_do');
    Route::get('/update/{id}', 'StudentController@update');
    Route::post('/update_do/{id}', 'StudentController@update_do');
    Route::get('/delete/{id}', 'StudentController@delete');

});

