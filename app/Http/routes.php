<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','FrontController@index');
Route::get('admin','FrontController@admin');

Route::get('password/email','Auth\PasswordController@getEmail');
Route::post('password/email','Auth\PasswordController@postEmail');

Route::get('password/reset/{token}','Auth\PasswordController@getReset');
Route::post('password/reset','Auth\PasswordController@postReset');

Route::resource('user','UserController');
Route::resource('admin/role','RoleController');
Route::resource('admin/functionality','FunctionalityController');
Route::resource('admin/system','SystemController');
Route::resource('admin/menu','MenuController');
Route::resource('log','LogController');
Route::get('logout','LogController@logout');
