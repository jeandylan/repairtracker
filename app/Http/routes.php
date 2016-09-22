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

    $domainName=Request::server ("HTTP_HOST"); //obtain the full server name request
    if ($domainName=='admin.saasrepair.oooo'){ //if saas.admin means that we are the admin owner
        return view('admin');
    }

    return view('app');

});
Route::get("/googleAuth",'GoogleController@companyGoogleAuth');
//Route::get("/googleAuthSuccessful",'GoogleController@saveAuth');
Route::get("/sentEmail","GoogleController@sentEmail");
Route::get("/se","MailController@sentCommentEmail");


Route::post('/customerReply',"TicketController@customerComment");

Route::post('/registerCompany','SaasAdmin\CompanyController@register'); //create company ,Because it is in Folder May need artisan Autodump & specific use import
Route::get('/et','SaasAdmin\CompanyController@register');

#laravel api
Route::group(['prefix' => 'api'], function () {

    //user Login
    Route::post('/login','AuthenticateController@authenticate'); //create customer

    Route::group(['middleware' => ['jwtAuthMiddleware']], function () {
        /*sent sms*/
        Route::post("/sms","SmsController@sent");

        /*get Login profile Info */
        Route::get('/employee/myProfile','EmployeeController@getProfile');
        Route::get('/check','AuthenticateController@getAuthenticatedUser'); //create customer

        //Customer Route
        Route::get('/customers', 'CustomerController@index'); //get all customers
        Route::get('/customer/{id}','CustomerController@get'); //get customer data that have id provided
        Route::post('/customer','CustomerController@store'); //create customer
        Route::delete('/customer/{id}','CustomerController@destroy'); //delete customer that have id same as the one provided
        Route::put('/customer/{id}','CustomerController@update'); //update customer that have id coresponding to the one provided
        /*search cutomer */
        Route::get('/customerSearch','CustomerController@search');

        /*customer address*/
        Route::delete('/customer/address/{id}','CustomerAddressController@destroy'); //get address(es) For customer X
        Route::put('/customer/address/{id}', 'CustomerAddressController@update');
        Route::post('/customer/address', 'CustomerAddressController@store');
        /*customer email*/
        Route::delete('/customer/email/{id}','CustomerEmailController@destroy'); //get email(es) For customer X
        Route::put('/customer/email/{id}', 'CustomerEmailController@update');
        Route::post('/customer/email', 'CustomerEmailController@store');
        /*customer telephone*/
        Route::delete('/customer/telephone/{id}','CustomerTelephoneController@destroy'); //get telephone(es) For customer X
        Route::put('/customer/telephone/{id}', 'CustomerTelephoneController@update');
        Route::post('/customer/telephone', 'CustomerTelephoneController@store');


        //Tickets Routes
        Route::get('/tickets', 'TicketController@getAll'); //get all Tickets
        Route::get('/ticket/{id}', 'TicketController@get');
        Route::post('/ticket/{customerId}','TicketController@store'); //create a ticket for the customer with Id in url
        Route::delete('/ticket/{id}', 'TicketController@destroy');
        Route::put('/ticket/{id}', 'TicketController@update');// update  A ticket with specific Id
        //ticket Comments
        Route::get('/ticketComments/{id}','TicketCommentController@get');
        Route::post('/ticketComments/{id}','TicketCommentController@create');

        Route::get('ticketCustomFieldsData/{ticketId}','TicketController@getCustomFieldsData');
        Route::get('ticketCustomFields','TicketController@getCustomFields');
/* task Ticket Assign-Employee(assign Tech to ticket)*/
        Route::get('/ticketTechnician/{ticketId}','EmployeeTaskController@get');
        Route::post('/ticketTechnician/{ticketId}','EmployeeTaskController@create');
        Route::delete('/ticketTechnician/{taskId}','EmployeeTaskController@delete');
        Route::put('/ticketTechnician/{taskId}','EmployeeTaskController@update');
        /*ticket Stock*/
        Route::get('/ticketStock/{ticketId}','StockTicketController@get');
        Route::post('/ticketStock/{ticketId}','StockTicketController@create');
        Route::put('/ticketStock/{ticketId}','StockTicketController@update');


        /*Custom fields data,retreive ,post ,delete Save Data from Custom created Fields*/
        Route::get('/customTextFieldData/{formName}/{entity_id}','CustomTextFieldDataController@getFieldsDetails');
        Route::put('/customTextFieldData/{entity_id}', 'CustomTextFieldDataController@update');
        Route::post('/customTextFieldData', 'CustomTextFieldDataController@create');

        /*Custom Field Resource,used to created add ,delete custom Fields*/
        Route::get('/customTextField/{formName}','CustomTextFieldController@get');
        Route::Post('/customTextField','CustomTextFieldController@create');
        Route::put('/customTextField/{fieldId}','CustomTextFieldController@update');
        Route::delete('/customTextField/{id}', 'CustomTextFieldController@destroy');




        //stock Route
        Route::get('/stocks', 'StockController@getAll'); //get all Stock
        Route::get('/stock/{id}', 'StockController@get');//get Specific Stock
        Route::post('/stock','StockController@store'); //create a new Stock
        Route::delete('/stock/{id}', 'StockController@destroy');//Delete A Specific Stock
        Route::put('/stock/{id}', 'StockController@update');// Update A ticket with specific Id
        //search Stock ByName
        Route::put('/stockSearch', 'StockController@search');// Update A ticket with specific Id
        //Stock lvl
        Route::get('/stockLevel/{stockId}','StockController@level');
        Route::post('/stockReduce/{stockId}','StockController@stockLocationReduce');

        //supplier Route
        Route::get('/suppliers', 'SupplierController@getAll'); //get all Suppl.
        Route::get('/supplier/{id}', 'SupplierController@get');//get Specific Suppl.
        Route::post('/supplier','SupplierController@store'); //create a new Suppl.
        Route::delete('/supplier/{id}', 'SupplierController@destroy');//Delete A Specific Suppl.
        Route::put('/supplier/{id}', 'SupplierController@update');// Update A suppl. with specific Id

        /*supplier address*/
        Route::delete('/supplier/address/{id}','SupplierAddressController@destroy'); //get address(es) For customer X
        Route::put('/supplier/address/{id}', 'SupplierAddressController@update');
        Route::post('/supplier/address', 'SupplierAddressController@store');
        /*supplier email*/
        Route::delete('/supplier/email/{id}','SupplierEmailController@destroy'); //get email(es) For customer X
        Route::put('/supplier/email/{id}', 'SupplierEmailController@update');
        Route::post('/supplier/email', 'SupplierEmailController@store');
        /*supplier telephone*/
        Route::delete('/supplier/telephone/{id}','SupplierTelephoneController@destroy'); //get telephone(es) For customer X
        Route::put('/supplier/telephone/{id}', 'SupplierTelephoneController@update');
        Route::post('/supplier/telephone', 'SupplierTelephoneController@store');




        //employee Route
        Route::get('/employees', 'EmployeeController@getAll'); //get all Emp.
        Route::get('/employee/{id}', 'EmployeeController@get');//get Specific Emp.
        Route::post('/employee','EmployeeController@store'); //create a new Emp.
        Route::delete('/employee/{id}', 'EmployeeController@destroy');//Delete A Specific Emp.
        Route::put('/employee/{id}', 'EmployeeController@update');// Update A Emp. with specific Id


        /*employee address*/
        Route::delete('/employee/address/{id}','EmployeeAddressController@destroy'); //get address(es) For customer X
        Route::put('/employee/address/{id}', 'EmployeeAddressController@update');
        Route::post('/employee/address', 'EmployeeAddressController@store');
        /*employee email*/
        Route::delete('/employee/email/{id}','EmployeeEmailController@destroy'); //get email(es) For customer X
        Route::put('/employee/email/{id}', 'EmployeeEmailController@update');
        Route::post('/employee/email', 'EmployeeEmailController@store');
        /*employee telephone*/
        Route::delete('/employee/telephone/{id}','EmployeeTelephoneController@destroy'); //get telephone(es) For customer X
        Route::put('/employee/telephone/{id}', 'EmployeeTelephoneController@update');
        Route::post('/employee/telephone', 'EmployeeTelephoneController@store');

        /*estimation*/
        Route::get('/estimation/{ticketId}','EstimationController@get');

        Route::post('/estimationLabour/{ticketId}','EstimationController@createEstimationLabour');
        Route::put('/estimationLabour/{estimationLabourId}','EstimationController@updateEstimationLabour');
        Route::delete('/estimationLabour/{estimationLabourId}','EstimationController@deleteEstimationLabour');

        Route::post('/estimationItem/{ticketId}','EstimationController@createEstimationItem');
        Route::put('/estimationItem/{estimationItemId}','EstimationController@updateEstimationItem');
        Route::delete('/estimationItem/{estimationItemId}','EstimationController@deleteEstimationItem');


        /*invoice*/
        Route::get('/invoice/{ticketId}','InvoiceController@get');
        Route::post('/invoice/labour/{ticketId}','InvoiceController@createLabour');
        Route::put('/invoice/labour/{labourId}','InvoiceController@updateLabour');


        /*calendar*/
        Route::get('/calendar/all','CalendarController@getAllEventDates'); ///all events loc
        Route::get('/calendar/locationAppointment','CalendarController@getLocationAppointmentDates'); //APpoint with client for loc
        Route::get('/calendar/locationTicketEstimationCompletionDates','CalendarController@getTicketEstimatedCompletionDates'); //ticket Completion for loca
        Route::get('/calendar/LocationTicketTaskEstimationCompletionDate','CalendarController@getLocationTicketTaskEstimationCompletionDate'); //Ticket Task Completion

        /* technician Routes all Technician Are Employee */

        Route::get('/technician', 'EmployeeController@getTechnician'); //get all Emp of type Tech
        /*searching Technician*/
        Route::get('/technicianSearch', 'EmployeeController@searchTechnician'); //search Tech




    });
});