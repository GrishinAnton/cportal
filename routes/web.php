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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function () {
    //Personal groups
    Route::get('api/personal/groups', 'Api\Personal\GroupController@getGroups')->name('api.personal.groups');
    Route::post('api/personal/{personalId}/add/group', 'Api\Personal\GroupController@addGroup')->name('api.personal.add.groups');

    //Personal companies
    Route::get('api/personal/companies', 'Api\Personal\CompanyController@getCompanies')->name('api.personal.companies');
    Route::post('api/personal/{personalId}/add/company', 'Api\Personal\CompanyController@addCompany')->name('api.personal.add.company');

    //Personal
    Route::get('api/personal', 'Api\Personal\PersonalController@index')->name('web.personal.index');
    Route::get('api/personal/{id}/group-company', 'Api\Personal\PersonalController@getCompanyGroupPersonal')->name('web.personal.company.group');

    //Resource Personal Salary
    Route::post('api/personal/{persId}/salary/store', 'Api\Personal\SalaryController@store')->name('api.personal.salary.store');
    Route::post('api/personal/salary/{salaryId}/update', 'Api\Personal\SalaryController@update')->name('api.personal.salary.update');
    Route::get('api/personal/{persId}/salary', 'Api\Personal\SalaryController@show')->name('api.personal.salary.show');

    //Resource Personal Project Costs
    Route::get('api/personal/{persId}/project-costs', 'Api\Personal\ProjectCostController@index')->name('api.personal.project-costs.index');
    Route::post('api/personal/{persId}/project-costs/store')->name('api.personal.project-costs.store');

    //Resourse Report
    Route::get('api/report/personal', 'Api\Report\PersonalController@index');
    Route::get('api/report/worktime/{year}', 'Api\Report\WorkTimeController@workTimeByMonth');
    Route::get('api/report/personal/{persId}/salaries/{year}/{month}', 'Api\Report\PersonalController@salaries');

    //Resource Report Costs
    Route::get('api/report/costs', 'Api\Report\CostController@index')->name('api.report.costs.index');
    Route::post('api/report/costs', 'Api\Report\CostController@store')->name('api.report.costs.store');
    Route::post('api/report/costs/{costId}', 'Api\Repost\CostController@update')->name('api.report.costs.update');

    //----------------------------------------------------------------------------------------------------------------//

    //Personal
    Route::get('personal', 'PersonalController@index')->name('web.personal.index');
    Route::get('personal/{id}', 'PersonalController@show')->name('web.personal.show');
    Route::post('personal/{pers_id}/is-active/store', 'PersonalController@store');

    //Главная
    Route::get('dashboard', 'HomeController@index');
    
    //Projects
    Route::get('projects', 'ProjectController@index');
    Route::get('projects/{id}', 'ProjectController@show');

    //Report
    Route::get('report', 'ReportController@index')->name('web.report');

    //Productivity
    Route::get('productivity', 'ProductivityController@index')->name('web.productivity');

    //Employees
    Route::get('employees', 'EmployeesController@index')->name('web.employees');

    //Финансы
    Route::get('report/costs', 'Report\CostController@index')->name('web.report.costs.index');
});
