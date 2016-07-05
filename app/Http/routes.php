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

Route::get('/', function () {
    return view('app');
});

#laravel api
Route::group(['prefix' => 'api'], function () {
    Route::get('/customers', 'CustomerController@index');
    Route::get('/customer/{id}','CustomerController@get');
    Route::get('/test/1', function () {
        return view('app');
    });

});