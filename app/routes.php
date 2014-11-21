<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'UsersController@login');
Route::get('login', 'UsersController@login');

/* Secure pages */
Route::group(array(
    'before' => 'auth'
), function ()	{
	Route::get('dashboard', 'DashboardController@index');

	/* for receipt transations */
	Route::get('receipt', 'TransationsController@receipt');
	Route::post('receipt/add', 'TransationsController@addReceipt');

	/* for expense transations */
	Route::get('receipt', 'TransationsController@receipt');
	Route::post('receipt/add', 'TransationsController@addReceipt');

	/* for expense transations */
	Route::get('expense', 'TransationsController@expense');
	Route::post('expense/add', 'TransationsController@addExpense');

	/* for reporting */
	Route::get('report', 'ReportController@index');

	/* for branchs setting */
	Route::get('setting/branch/{id?}','SettingCotroller@branchView')->where('id','[0-9]+');
	Route::post('setting/branch/add/{id?}','SettingCotroller@branchAdd')->where('id','[0-9]+');

	/* for Banks setting */
	Route::get('setting/bank/{id?}','SettingCotroller@bankView')->where('id','[0-9]+');
	Route::post('setting/bank/add/{id?}','SettingCotroller@bankAdd')->where('id','[0-9]+');

	/* for Expense setting */
	Route::get('setting/expense/{id?}','SettingCotroller@expenseView')->where('id','[0-9]+');
	Route::post('setting/expense/add/{id?}','SettingCotroller@expenseAdd')->where('id','[0-9]+');

	/* searching */
	Route::get('search','SearchController@index');
	Route::post('search','SearchController@search');
});

Route::post('login', 'UsersController@doLogin');
Route::get('logout', 'UsersController@logout');
