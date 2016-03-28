<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('loginform', 'Auth\AuthController@showLoginForm');
//Route::get('/', 'Auth\AuthController@showLoginForm');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
	Route::auth();
	Route::get('/home', 'HomeController@index');
	Route::get('/', 'Home@index');
	Route::get('/svcctl/{service}/{action}', 'Dashboard@svcctl');
        Route::get('/whtlst/{action}/{domain?}', 'Dashboard@whtlst');
        Route::get('/domainreq/{action}/{domain?}', 'Dashboard@domainreq');

});
