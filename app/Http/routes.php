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
Route::get('admin/egress/employees','EgressController@employees');

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
Route::resource('admin/schedule','ScheduleController');
Route::resource('admin/hour','HourController');
Route::resource('admin/extra','ExtraController');
Route::resource('admin/category','CategoryController');
Route::resource('admin/item','ItemController');
Route::resource('admin/order','OrderController');
Route::resource('admin/income','IncomeController');
Route::resource('admin/egress','EgressController');
Route::resource('log','LogController');
Route::get('admin/report/debit','ReportController@debit');
Route::get('admin/report/groups','ReportController@groups');
Route::get('admin/report/debitbygroups','ReportController@debitByGroups');
Route::get('admin/report/income','ReportController@income');
Route::get('admin/report/incomeByEmployee/{fecha_inicio?}/{fecha_fin?}','ReportController@incomeByEmployee');
Route::get('logout','LogController@logout');
Route::get('admin/groups/{id}','StartclassController@getgroups');
Route::get('admin/report/group/{id}','ReportController@group');
Route::get('admin/report/chart/{inicio}/{fin}','ReportController@chart');
Route::get('admin/report/students','ReportController@students');
Route::get('admin/payments/{id}','PaymentController@getpayments');
Route::get('admin/search/{name}','StudentController@getpeople');
Route::get('admin/inscriptions/{id}','PaymentController@getinscriptions');
Route::get('admin/payment/pdf/{id?}','PaymentController@pdf');
Route::get('admin/order/pdf/{id?}','OrderController@pdf');
Route::get('admin/income/pdf/{id?}','IncomeController@pdf');
Route::get('admin/egress/pdf/{id?}','EgressController@pdf');
Route::get('admin/egress/paymentform/{id?}','EgressController@paymentform');
Route::get('admin/egress/mypayment/{id?}','EgressController@mypayment');
Route::get('admin/schedule/ver/{schedule?}','ScheduleController@ver');
Route::get('admin/schedule/clonar/{schedule?}','ScheduleController@clonar');
Route::get('admin/teacher/horario/{teacher?}','TeacherController@horario');
Route::get('admin/group/horario/{group?}','GroupController@horario');
Route::get('admin/student/search/{id}','StudentController@search');
Route::post('pass/changePassword','UserController@changePassword');
Route::post('mail','FrontController@mail');
Route::get('pass/changePasswordForm','UserController@changePasswordForm');

Route::post('admin/egress/savepayment','EgressController@savepayment');