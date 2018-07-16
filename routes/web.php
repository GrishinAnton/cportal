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

Route::get('load', 'Api\Personal\TaskByHubController@load')->name('load');


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
    Route::get('api/personal/costs', 'Api\Personal\CostController@index')->name('api.personal.costs');

    //teamleads
    Route::get('api/personal/groups/teamleads', 'Api\Personal\TeamleadController@teamleads')->name('api.personal.groups.teamleads');
    Route::post('api/personal/{personalId}/add/personal', 'Api\Personal\TeamleadController@addPersonal')->name('api.personal.addPersonal');
    Route::get('api/personal/{personalId}/users', 'Api\Personal\TeamleadController@users')->name('api.personal.users');
    Route::get('api/personal/{personalId}/teamlead', 'Api\Personal\TeamleadController@teamlead')->name('api.personal.teamlead');
    Route::post('api/personal/{personalId}/reassigned', 'Api\Personal\TeamleadController@reassigned')->name('api.personal.reassigned');


    //Resource Personal Salary
    Route::post('api/personal/{persId}/salary/store', 'Api\Personal\SalaryController@store')->name('api.personal.salary.store');
    Route::post('api/personal/salary/{salaryId}/update', 'Api\Personal\SalaryController@update')->name('api.personal.salary.update');
    Route::get('api/personal/{persId}/salary', 'Api\Personal\SalaryController@show')->name('api.personal.salary.show');

    //Resource Personal Project Costs
    Route::get('api/personal/{persId}/project-costs', 'Api\Personal\ProjectCostController@index')->name('api.personal.project-costs.index');
    Route::post('api/personal/{persId}/project-costs/store', 'Api\Personal\ProjectCostController@store')->name('api.personal.project-costs.store');

    //Resource Report Costs
    Route::get('api/report/costs', 'Api\Report\CostController@index')->name('api.report.costs.index');
    Route::post('api/report/costs', 'Api\Report\CostController@store')->name('api.report.costs.store');
    Route::post('api/report/costs/{costId}', 'Api\Report\CostController@update')->name('api.report.costs.update');

    //Resource Report Productivity
    Route::get('api/report/productivity', 'Api\Report\ProductivityController@index')->name('api.report.productivity');

    //Resource Report Productivity
    Route::get('api/report/productivity-two-week', 'Api\Report\ProductivityController@indexTwoWeek')->name('api.report.productivity-two-week');

    //Resource Report Summary
    Route::get('api/report/summary', 'Api\Report\SummaryController@index')->name('api.report.summary');


    Route::get('api/report/projects/managers', 'Api\Report\Project\ManagerController@index')->name('api.report.managers.index');
    Route::get('api/report/projects/statuses', 'Api\Report\Project\StatusController@index')->name('api.report.project.statuses.show');
    Route::get('api/report/projects/{id}/hours-spent', 'Api\Report\Project\TimeController@show')->name('api.report.projects.show');
    Route::get('api/report/projects/{id}/fot', 'Api\Report\Project\FotController@show')->name('api.report.projects.show');
    Route::get('api/report/projects/{id}/costs', 'Api\Report\Project\CostController@show')->name('api.report.costs.show');
    Route::get('api/report/projects/{id}', 'Api\Report\Project\ProjectController@show')->name('api.report.project.show');
    Route::get('api/report/projects', 'Api\Report\Project\ProjectController@index')->name('api.report.project.index');

    Route::post('api/report/projects/{id}', 'Api\Report\Project\ProjectController@update')->name('api.report.project.update');

    Route::get('api/report/widget-time', 'Api\Report\WidgetController@index')->name('api.report.widget.index');

    //----------------------------------------------------------------------------------------------------------------//

    //Personal
    Route::get('personal', 'PersonalController@index')->name('web.personal.index');
    Route::get('personal/{id}', 'PersonalController@show')->name('web.personal.show');
    Route::post('personal/{pers_id}/is-active/store', 'PersonalController@store');

    //Главная
    Route::get('dashboard', 'HomeController@index');
    
    //Projects
    Route::get('projects', 'ProjectController@index')->name('web.projects.index');
    Route::get('projects/{id}', 'ProjectController@show')->name('web.projects.show');

    //Report
    Route::get('report', 'ReportController@index')->name('web.report');

    //Productivity
    Route::get('productivity', 'ProductivityController@index')->name('web.productivity');

    Route::get('productivity-two-week', 'ProductivityController@indexTwoWeek')->name('web.productivity-two-week');


    //Employees
    Route::get('employees', 'EmployeesController@index')->name('web.employees');

    //Финансы
    Route::get('report/costs', 'Report\CostController@index')->name('web.report.costs.index');

    //Active Collab
    Route::get('activecollab', 'ActiveCollab\ApiController@index')->name('web.activecollab.index');
    Route::get('activecollab/personal', 'ActiveCollab\ApiController@personal')->name('web.activecollab.personal');
    Route::get('activecollab/projects', 'ActiveCollab\ApiController@projects')->name('web.activecollab.projects');
    Route::get('activecollab/tasks', 'ActiveCollab\ApiController@tasks')->name('web.activecollab.tasks');
    Route::get('activecollab/time-records', 'ActiveCollab\ApiController@timeRecords')->name('web.activecollab.time-records');
    Route::get('activecollab/time-records/all', 'ActiveCollab\ApiController@timeRecordsAll')->name('web.activecollab.time-records.all');

    Route::get('api/send-email/personal-times', 'Email\PersonalTimeController@send')->name('api.send-email.personal-times');

    Route::get('report/widget-time', 'Report\WidgetController@index')->name('web.report.widget.index');
});
