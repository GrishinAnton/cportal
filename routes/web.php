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

// Authentication Routes...
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function () {
    //Главная
    Route::get('dashboard', 'HomeController@index');

    //Resourse Personal
    Route::get('api/personal/{id}', 'Api\PersonalController@show');
    Route::post('api/personal/{pers_id}/salary/store/{salary_id?}', 'Api\PersonalController@storeSalary');
    Route::post('api/personal/{pers_id}/costs/store', 'Api\PersonalController@storeCosts');

    //Personal
    Route::get('personal', 'PersonalController@index');
    Route::get('personal/{id}', 'PersonalController@show');
    Route::post('personal/{pers_id}/is-active/store', 'PersonalController@store');
    
    //Projects
    Route::get('projects', 'ProjectController@index');
    Route::get('projects/{id}', 'ProjectController@show');

    //Resourse Report
    Route::get('api/report/personal/all', 'Api\Report\PersonalController@all');
    Route::get('api/report/worktime/{year}', 'Api\Report\WorkTimeController@workTimeByMonth');
    Route::get('api/report/personal/{persId}/salaries/{year}/{month}', 'Api\Report\PersonalController@salaries');

    //Report
    Route::get('report', 'ReportController@index')->name('web.report');

    //Финансы
    Route::get('finance/costs', 'Finance\CostsController@index');
    Route::put('finance/costs', 'Finance\CostsController@edit');
});
