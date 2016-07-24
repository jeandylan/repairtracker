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
    //Customer Route
    Route::get('/customers', 'CustomerController@index'); //get all customers
    Route::get('/customer/{id}','CustomerController@get'); //get customer data that have id provided
    Route::post('/customer','CustomerController@store'); //create customer
    Route::delete('/customer/{id}','CustomerController@destroy'); //delete customer that have id same as the one provided
    Route::put('/customer/{id}','CustomerController@update'); //update customer that have id coresponding to the one provided

    //Tickets Routes
    Route::get('/tickets', 'TicketController@getAll'); //get all Tickets
    Route::get('/ticket/{id}', 'TicketController@get');
    Route::post('/ticket/{customerId}','TicketController@store'); //create a ticket for the customer with Id in url
    Route::delete('/ticket/{id}', 'TicketController@destroy');
    Route::put('/ticket/{id}', 'TicketController@update');// delete A ticket with specific Id


    //stock Route
    Route::get('/stocks', 'StockController@getAll'); //get all Stock
    Route::get('/stock/{id}', 'StockController@get');//get Specific Stock
    Route::post('/stock','StockController@store'); //create a new Stock
    Route::delete('/stock/{id}', 'StockController@destroy');//Delete A Specific Stock
    Route::put('/stock/{id}', 'StockController@update');// Update A ticket with specific Id

    //supplier Route
    Route::get('/suppliers', 'SupplierController@getAll'); //get all Suppl.
    Route::get('/supplier/{id}', 'SupplierController@get');//get Specific Suppl.
    Route::post('/supplier','SupplierController@store'); //create a new Suppl.
    Route::delete('/supplier/{id}', 'SupplierController@destroy');//Delete A Specific Suppl.
    Route::put('/supplier/{id}', 'SupplierController@update');// Update A suppl. with specific Id

    //employee Route
    Route::get('/employees', 'EmployeeController@getAll'); //get all Emp.
    Route::get('/employee/{id}', 'EmployeeController@get');//get Specific Emp.
    Route::post('/employee','EmployeeController@store'); //create a new Emp.
    Route::delete('/employee/{id}', 'EmployeeController@destroy');//Delete A Specific Emp.
    Route::put('/employee/{id}', 'EmployeeController@update');// Update A Emp. with specific Id


});