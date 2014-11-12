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
	Route::get('dashboard', 'dashboardController@index');
	Route::get('transations/{type}', 'TransationsController@index');
	Route::post('transations/add', 'TransationsController@addTransations');
});

Route::post('login', 'UsersController@doLogin');
Route::get('logout', 'UsersController@logout');
