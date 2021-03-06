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

Route::group(['prefix' => 'admin', 'middleware' => 'admin_only'], function(){
  // Company routes

  // Route::resource('companies', 'CompanyController');

  Route::get('companies', ['uses' => 'CompanyController@index', 'as' => 'companies.index']);
  Route::get('companies/create', ['uses' => 'CompanyController@create', 'as' => 'companies.create']);
  Route::post('companies/bulk_upload', ['uses' => 'CompanyController@bulkUpload', 'as' => 'companies.bulk_upload']);
  Route::get('companies/{id}', ['uses' => 'CompanyController@show', 'as' => 'companies.show']);
  Route::get('companies/{id}/edit', ['uses' => 'CompanyController@edit', 'as' => 'companies.edit']);
  Route::post('companies', ['uses' => 'CompanyController@store', 'as' => 'companies.store']);
  Route::put('companies/{id}', ['uses' => 'CompanyController@update', 'as' => 'companies.update']);
  Route::get('companies/{id}/delete', ['uses' => 'CompanyController@destroy', 'as' => 'companies.destroy']);

  // Employee routes

  // Route::resource('employees', 'EmployeeController');

  Route::get('employees', ['uses' => 'EmployeeController@index', 'as' => 'employees.index']);
  Route::get('employees/create', ['uses' => 'EmployeeController@create', 'as' => 'employees.create']);
  Route::post('employees/bulk_upload', ['uses' => 'EmployeeController@bulkUpload', 'as' => 'employees.bulk_upload']);
  Route::get('employees/{id}', ['uses' => 'EmployeeController@show', 'as' => 'employees.show']);
  Route::get('employees/{id}/edit', ['uses' => 'EmployeeController@edit', 'as' => 'employees.edit']);
  Route::post('employees', ['uses' => 'EmployeeController@store', 'as' => 'employees.store']);
  Route::put('employees/{id}', ['uses' => 'EmployeeController@update', 'as' => 'employees.update']);
  Route::get('employees/{id}/delete', ['uses' => 'EmployeeController@destroy', 'as' => 'employees.destroy']);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


