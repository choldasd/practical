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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth','preventBackHistory']], function () {

	Route::resources([
		//'company' => 'CompanyController',
		'employee' => 'EmployeeController',
	]);
	Route::resource('company', 'CompanyController')->only([
		'edit', 'update'
	]);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
	Route::get('/', 'Auth\LoginController@showAdminLoginForm');
	Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('show_admin_login_form');	
	Route::post('login', 'Auth\LoginController@adminLogin')->name('admin_login');
	
	//Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('show_admin_register_form');
	//Route::post('register', 'Auth\RegisterController@createAdmin')->name('admin_register');
});

//Authenticated Routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>['admin_auth','preventBackHistory']], function () {
		
	Route::post('logout', 'Auth\LoginController@logout')->name('admin_logout');	
	Route::get('logout', 'Auth\LoginController@logout')->name('admin_logout');	
	Route::get('dashboard', 'DashboardController@index')->name('admin_dashboard');
		
	Route::resource('companies', 'CompanyController')->except(['view']);
	Route::resource('employees', 'EmployeeController')->except(['view']);
	
	
	
});
