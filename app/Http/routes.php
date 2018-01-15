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
Route::resource('admin/teacher','TeacherController');
Route::resource('admin/student','StudentController');
Route::resource('admin/office','OfficeController');
Route::resource('admin/career','CareerController');
Route::resource('admin/subject','SubjectController');
Route::resource('admin/employee','EmployeeController');
Route::resource('admin/startclass','StartclassController');
Route::resource('admin/group','GroupController');
Route::resource('admin/inscription','InscriptionController');
Route::resource('admin/payment','PaymentController');
Route::resource('admin/backup','BackupController');
Route::resource('log','LogController');
Route::get('admin/report/debit','ReportController@debit');
Route::get('admin/report/groups','ReportController@groups');
Route::get('admin/report/debitbygroups','ReportController@debitByGroups');
Route::get('admin/report/income','ReportController@payments');
Route::get('logout','LogController@logout');
Route::get('admin/groups/{id}','StartclassController@getgroups');
Route::get('admin/report/group/{id}','ReportController@group');
Route::get('admin/report/chart/{inicio}/{fin}','ReportController@getchartmensual');
Route::get('admin/payments/{id}','PaymentController@getpayments');
Route::get('admin/search/{name}','StudentController@getpeople');
Route::get('admin/inscriptions/{id}','PaymentController@getinscriptions');
Route::get('admin/payment/pdf/{id?}','PaymentController@pdf');
Route::get('admin/student/search/{id}','StudentController@search');
