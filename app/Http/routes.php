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

    $domainName=Request::server ("HTTP_HOST");
    if ($domainName=='admin.saasrepair1.xyz'){ //if saas.admin means that we are the admin owner
        return view('admin');
    }

    return view('app');


})->middleware('tenantMiddleware');





Route::get("/googleAuth",'GoogleController@companyGoogleAuth');
//Route::get("/googleAuthSuccessful",'GoogleController@saveAuth');
Route::get("/sentEmail","GoogleController@sentEmail");
Route::get("/se","MailController@sentCommentEmail");


Route::post('/customerReply',"TicketController@customerComment");


Route::get('/et','CompanyController@register');



Route::get('/saasValidate','CompanyController@companyDomain');
Route::get('/saasIsValid','CompanyController@validateTenantHostName');


/*Saas Admin*/
Route::group(['prefix'=>'saas','middleware'=>['SaasLogin','securityMiddleware']],function (){ //All Route For Saas Admin
    Route::post('/login','SaasAdmin\CompanyController@login'); //login
    Route::get('/companies','SaasAdmin\CompanyController@all'); //get all company
    Route::get('/messages','SaasAdmin\MessagesController@all'); //get all messages
    Route::get('/supporters','SaasAdmin\SupporterController@all'); //get all supporters
    ///  Route::get('/companies','SaasAdminCompanyController@register');//get All Company Register

    Route::get('/supporter/{id}','SaasAdmin\SupporterController@getSupporter');
    Route::post('/supporter','SaasAdmin\SupporterController@createSupporter'); //create Supporter ,Because it is in Folder May need artisan Autodump & specific us
    Route::delete('/supporter/{id}','SaasAdmin\SupporterController@deleteSupporter');
    Route::put('/supporter/{id}','SaasAdmin\SupporterController@updateSupporter');
    Route::get('/messages/{id}','SaasAdmin\MessagesController@getMessage');
    Route::post('/messages','SaasAdmin\MessagesController@createMessage');
    Route::delete('/messages/{id}','SaasAdmin\MessagesController@deleteMessage');
    Route::get('/company/{id}','SaasAdmin\CompanyController@getCompany');
    Route::post('/company','SaasAdmin\CompanyController@createCompany'); //create company ,Because it is in Folder May need artisan Autodump & specific us
    Route::delete('/company/{id}','SaasAdmin\CompanyController@deleteCompany');
    Route::put('/company/{id}','SaasAdmin\CompanyController@updateCompany'); //company Detaisl ,Because it is in Folder May need artisan Autodump & specific use import

    //company Locations updateCompanyLocation
    Route::get('/companyLocations/{companyId}','SaasAdmin\CompanyController@getCompanyLocations');
    Route::put('/companyLocations/{id}','SaasAdmin\CompanyController@updateCompanyLocation');
    Route::post('/companyLocations/{companyId}','SaasAdmin\CompanyController@createCompanyLocation');



});

#laravel api
Route::group(['prefix' => 'api'], function () {

    Route::group(['middleware' =>['securityMiddleware']],function () {
        //These route below prevent xss , but enable to query the saas db/or tenant table if middle ware Tenant is used
        Route::post("/payment",'SaasAdmin\CompanyController@payment');

        Route::get('/getActiveCompanyLocations/{companyName}', 'SaasAdmin\CompanyController@getActiveCompanyLocationsByName'); //get the company locations avaialbel
        // e.g orange will mahebourg.orange.xxx,curepipe.orange.yyyyyyyy
        Route::post('/login', 'AuthenticateController@authenticate')->middleware('tenantMiddleware'); //login For locations  Technician & location Admin
        Route::post('/loginSuperAdmin', 'AuthenticateController@authenticateSuperAdmin')->middleware('tenantMiddleware'); //the login For the Super Admin Only(shop owner)
    });

    /*these route use special Xss Security principals, will let <p>,<b> but remove script tags,because it will store TinyMice Data*/
    Route::group(['middleware' => ['jwtAuthMiddleware','tenantMiddleware']], function () {
        /*estimation Email*/
        Route::put('/customizeEstimationEmailHeader', 'EmailCustomizationController@saveEstimationEmailHeader'); //update customer that have id coresponding to the one provided
        Route::put('/customizeEstimationEmailFooter', 'EmailCustomizationController@saveEstimationEmailFooter'); //update customer that have id coresponding to the
        Route::get('/customizeEstimationEmailHeader', 'EmailCustomizationController@getEstimationEmailHeader'); //update customer that have id coresponding to the one provided
        Route::get('/customizeEstimationEmailFooter', 'EmailCustomizationController@getEstimationEmailFooter'); //update customer that have id coresponding to the
        /*Invoice Email Customization*/
        Route::put('/customizeInvoiceEmailHeader', 'EmailCustomizationController@saveInvoiceEmailHeader'); //update customer that have id coresponding to the one provided
        Route::put('/customizeInvoiceEmailFooter', 'EmailCustomizationController@saveInvoiceEmailFooter'); //update customer that have id coresponding to the
        Route::get('/customizeInvoiceEmailHeader', 'EmailCustomizationController@getInvoiceEmailHeader'); //update customer that have id coresponding to the one provided
        Route::get('/customizeInvoiceEmailFooter', 'EmailCustomizationController@getInvoiceEmailFooter'); //update customer that have id coresponding to the

        /*shop Customization*/
        Route::put('/setShopColor', 'ShopCustomizationController@setShopColor');
        Route::get('/getShopColor', 'ShopCustomizationController@getShopColor');
    });

/*all other Routes for Shop exclude shopCustomizaion*/
        Route::group(['middleware' => ['jwtAuthMiddleware','tenantMiddleware','securityMiddleware']], function () {

            /*sent sms*/
            Route::post("/sms", "SmsController@sent");

            /*get Login profile Info */
            Route::get('/allEmployee/myProfile', 'AllEmployeeController@getProfile');
            Route::get('/employee/myProfile', 'EmployeeController@getProfile');
            Route::get('/check', 'AuthenticateController@getAuthenticatedUser'); //create customer

            // All Customer Route
            Route::get('/customers', 'CustomerController@index'); //get all customers
            Route::get('/customer/{id}', 'CustomerController@get'); //get customer data that have id provided
            Route::post('/customer', 'CustomerController@store'); //create customer
            Route::delete('/customer/{id}', 'CustomerController@destroy'); //delete customer that have id same as the one provided
            Route::put('/customer/{id}', 'CustomerController@update'); //update customer that have id coresponding to the one provided


            /*search cutomer */
            Route::get('/customerSearch', 'CustomerController@search');

            /*customer address*/
            Route::delete('/customer/address/{id}', 'CustomerAddressController@destroy'); //get address(es) For customer X
            Route::put('/customer/address/{id}', 'CustomerAddressController@update');
            Route::post('/customer/address', 'CustomerAddressController@store');
            /*customer email*/
            Route::delete('/customer/email/{id}', 'CustomerEmailController@destroy'); //get email(es) For customer X
            Route::put('/customer/email/{id}', 'CustomerEmailController@update');
            Route::post('/customer/email', 'CustomerEmailController@store');
            /*customer telephone*/
            Route::delete('/customer/telephone/{id}', 'CustomerTelephoneController@destroy'); //get telephone(es) For customer X
            Route::put('/customer/telephone/{id}', 'CustomerTelephoneController@update');
            Route::post('/customer/telephone', 'CustomerTelephoneController@store');


            //Tickets Routes
            Route::get('/tickets', 'TicketController@getAll'); //get all Tickets
            Route::get('/ticket/{id}', 'TicketController@get');
            Route::post('/ticket/{customerId}', 'TicketController@store'); //create a ticket for the customer with Id in url
            Route::delete('/ticket/{id}', 'TicketController@destroy');
            Route::put('/ticket/{id}', 'TicketController@update');// update  A ticket with specific Id

            //ticket Email Owners (get customer Email)
            Route::get('/ticketEmail/{ticketId}','TicketController@getCustomerEmail');


            //ticket Comments
            Route::get('/ticketComments/{id}', 'TicketCommentController@get');
            Route::post('/ticketComments/{id}', 'TicketCommentController@create');

            //ticket custom Fields*/
            Route::get('/ticketCustomFieldUpdating/{ticketId}', 'TicketController@getCustomFieldUpdating');

            Route::get('ticketCustomFieldsData/{ticketId}', 'TicketController@getCustomFieldsData');
            Route::get('ticketCustomFields', 'TicketController@getCustomFields');
            /* task Ticket Assign-Employee(assign Tech to ticket)*/
            Route::get('/ticketTechnician/{ticketId}', 'EmployeeTaskController@get'); //get all Techincian Task (admin usage)
            Route::post('/ticketTechnician/{ticketId}', 'EmployeeTaskController@create');
            Route::delete('/ticketTechnician/{taskId}', 'EmployeeTaskController@delete');
            Route::put('/ticketTechnician/{taskId}', 'EmployeeTaskController@update'); //update a task
            Route::get('/ticketTechnicianMyTask', 'EmployeeTaskController@getMyTask'); //get current login user Task
            /*notification new Task*/
            Route::get('/ticketTechnicianMyTaskNotification', 'EmployeeTaskController@myNotificationTicket');
            Route::get('/ticketTechnicianMyTaskNotificationRead', 'EmployeeTaskController@readAllNotificationTicket'); //mark all notif as read

            /*ticket Stock*/
            Route::get('/ticketStock/{ticketId}', 'StockTicketController@get');
            Route::post('/ticketStock/{ticketId}', 'StockTicketController@create');
            Route::put('/ticketStock/{ticketId}', 'StockTicketController@update');


            /*Custom fields data,retreive ,post ,delete Save Data from Custom created Fields*/
            Route::get('/customTextFieldData/{formName}/{entity_id}', 'CustomTextFieldDataController@getFieldsDetails');
            Route::put('/customTextFieldData/{entity_id}', 'CustomTextFieldDataController@update');
            Route::post('/customTextFieldData', 'CustomTextFieldDataController@create');

            /*Custom Field Resource,used to created add ,delete custom Fields*/
            Route::get('/customTextField/{formName}', 'CustomTextFieldController@get');
            Route::Post('/customTextField', 'CustomTextFieldController@create');
            Route::put('/customTextField/{fieldId}', 'CustomTextFieldController@update');
            Route::delete('/customTextField/{id}', 'CustomTextFieldController@destroy');


            //stock Route
            Route::get('/stocks', 'StockController@getAll'); //get all Stock
            Route::get('/stock/{id}', 'StockController@get');//get Specific Stock
            Route::post('/stock', 'StockController@store'); //create a new Stock
            Route::delete('/stock/{id}', 'StockController@destroy');//Delete A Specific Stock
            Route::put('/stock/{id}', 'StockController@update');// Update A ticket with specific Id
            //Supplier that Supply Stock
            Route::get('/stockSupplier/{id}','StockController@getSuppliers');//uses stock id to get it's suppliers

            //search Stock ByName
            Route::get('/stockSearch', 'StockController@search');// Update A ticket with specific Id
            //Stock lvl
            Route::get('/stockLevel/{stockId}', 'StockController@level');
            Route::post('/stockReduce/{stockId}', 'StockController@stockLocationReduce');

            Route::post('/purchaseOrderEmail','MailController@sentPurchaseOrderMail'); //sent Purchase Order email



            //Location Stock As each Location have its stock lvl
            Route::get('/stocksLocation','StockLocationController@getAll'); //get all stocks Lvl of location (with url help to defin location)
            Route::get('/stockLocation/{stockLocationId}','StockLocationController@get'); //Get one stock detail of lvl at loc.
            Route::put('/stockLocation/{stockLocationId}','StockLocationController@update'); //update stock available at loc
            Route::get('/stockLocationSearch', 'StockLocationController@search');// Update A ticket with specific Id

            //supplier Route
            Route::get('/suppliers', 'SupplierController@getAll'); //get all Suppl.
            Route::get('/supplier/{id}', 'SupplierController@get');//get Specific Suppl.
            Route::post('/supplier', 'SupplierController@store'); //create a new Suppl.
            Route::delete('/supplier/{id}', 'SupplierController@destroy');//Delete A Specific Suppl.
            Route::put('/supplier/{id}', 'SupplierController@update');// Update A suppl. with specific Id

            //get stock supplied by supplier
            Route::get('/suppliedStock/{supplierId}','SupplierController@suppliedStock');
            Route::delete('/suppliedStock/{supplierId}','SupplierController@removeSuppliedStock');
            Route::post('/suppliedStock/{supplierId}','SupplierController@addSuppliedStock');

            /*supplier address*/
            Route::delete('/supplier/address/{id}', 'SupplierAddressController@destroy'); //get address(es) For customer X
            Route::put('/supplier/address/{id}', 'SupplierAddressController@update');
            Route::post('/supplier/address', 'SupplierAddressController@store');
            /*supplier email*/
            Route::delete('/supplier/email/{id}', 'SupplierEmailController@destroy');
            Route::put('/supplier/email/{id}', 'SupplierEmailController@update');
            Route::get('/supplier/email/{id}', 'SupplierEmailController@get'); //get email for supplier X
            Route::post('/supplier/email', 'SupplierEmailController@store');

            /*supplier telephone*/
            Route::delete('/supplier/telephone/{id}', 'SupplierTelephoneController@destroy'); //get telephone(es) For customer X
            Route::put('/supplier/telephone/{id}', 'SupplierTelephoneController@update');
            Route::post('/supplier/telephone', 'SupplierTelephoneController@store');




            // location employee Route
            Route::get('/employees', 'EmployeeController@getAll'); //get all Emp. for loc
            Route::get('/employee/{id}', 'EmployeeController@get');//get Specific Emp.
            Route::post('/employee', 'EmployeeController@store'); //create a new Emp.
            Route::delete('/employee/{id}', 'EmployeeController@destroy');//Delete A Specific Emp.
            Route::put('/employee/{id}', 'EmployeeController@update');// Update A Emp. with specific Id
            Route::put('/employeePassword/{id}', 'EmployeeController@updatePassword');// Update An Emp. password with specific Id
            //Role assign  to employee
            Route::post('/employeeAssignRole/{id}','EmployeeController@assignRole'); //Route is used for update/create employee Role

            /* technician route search Technician */
            Route::get('/technician', 'EmployeeController@getTechnician'); //get all Emp of type Tech
            /*searching Technician*/
            Route::get('/technicianSearch', 'EmployeeController@searchTechnician'); //search Tech



            ///All Employee Route For super Admin
            Route::get('/allEmployees', 'AllEmployeeController@getAll'); //get all Emp.
            Route::get('/allEmployee/{id}', 'AllEmployeeController@get');//get Specific Emp.
            Route::post('/allEmployee', 'AllEmployeeController@store'); //create a new Emp.
            Route::delete('/allEmployee/{id}', 'AllEmployeeController@destroy');//Delete A Specific Emp.
            Route::put('/allEmployee/{id}', 'AllEmployeeController@update');// Update A Emp. with specific Id
            Route::put('/allEmployeePassword/{id}', 'AllEmployeeController@updatePassword');// Update A Emp. with specific Id

            //Role asign to all employees(includes every subdomain)
            Route::post('/allEmployeeAssignRole/{id}','AllEmployeeController@assignRole'); //Route is used for update/create employee Role





            /*estimation*/
            Route::get('/estimation/{ticketId}', 'EstimationController@get');

            Route::post('/estimationLabour/{ticketId}', 'EstimationController@createEstimationLabour');
            Route::put('/estimationLabour/{estimationLabourId}', 'EstimationController@updateEstimationLabour');
            Route::delete('/estimationLabour/{estimationLabourId}', 'EstimationController@deleteEstimationLabour');

            Route::post('/estimationItem/{ticketId}', 'EstimationController@createEstimationItem');
            Route::put('/estimationItem/{estimationItemId}', 'EstimationController@updateEstimationItem');
            Route::delete('/estimationItem/{estimationItemId}', 'EstimationController@deleteEstimationItem');
            Route::post('/estimationEmail','MailController@sentEstimationMail');


            /*invoice*/
            Route::get('/invoice/{ticketId}', 'InvoiceController@get'); //get all Invoice details Includes labour,stocks
            Route::post('/invoiceLabour/{ticketId}', 'InvoiceController@createLabour'); //PostLabour
            Route::put('/invoiceLabour/{labourId}', 'InvoiceController@updateLabour');
            Route::delete('/invoiceLabour/{labourId}','InvoiceController@deleteLabour');
            /*email Invoice*/
            Route::post('/invoiceEmail','MailController@sentInvoiceMail');

            /*Dashboard**/
            Route::get('/dashboard/ticket/count', 'DashboardController@numberTicketForPeriod');
            Route::get('/dashboard/invoice/count', 'DashboardController@numberInvoiceForPeriod');
            Route::get('/dashboard/estimation/count', 'DashboardController@numberEstimationForPeriod');

            Route::get('/dashboard/newCustomer/count', 'DashboardController@numberNewCustomerForPeriod');

            Route::get('/dashboard/invoiceAmount', 'DashboardController@amountOfInvoiceForPeriod');


            /*calendar*/
            Route::get('/calendar/all', 'CalendarController@getAllEventDates'); ///all events loc
            Route::get('/calendar/locationAppointment', 'CalendarController@getLocationAppointmentDates'); //APpoint with client for loc
            Route::get('/calendar/locationTicketEstimationCompletionDates', 'CalendarController@getTicketEstimatedCompletionDates'); //ticket Completion for loca
            Route::get('/calendar/LocationTicketTaskEstimationCompletionDate', 'CalendarController@getLocationTicketTaskEstimationCompletionDate'); //Ticket Task Completion



            /*edit role permission (what a technician can do...)*/

            Route::put('/rolePermissions/{roleName}','RolePermissionController@update'); //update Role permisions takes an array of name
            Route::get('/rolePermissions/{roleName}','RolePermissionController@getThisRolePermission'); //get permission associated with role
            Route::get('/allPermissions','RolePermissionController@getAllPermission'); //get all permissions available


            /*import Export data */
            //export Data
            Route::get('/exportData/xml/customers','ImportExportDataController@customerToXml');
            Route::get('/exportData/json/customers','ImportExportDataController@customerToJson');

            Route::get('/exportData/xml/employees','ImportExportDataController@employeesToXml');
            Route::get('/exportData/json/employees','ImportExportDataController@employeesToJson');

            Route::get('/exportData/xml/stocks','ImportExportDataController@stockToXml');
            Route::get('/exportData/json/stocks','ImportExportDataController@stockToJson');

            Route::get('/exportData/xml/suppliers','ImportExportDataController@supplierToXml');
            Route::get('/exportData/json/suppliers','ImportExportDataController@supplierToJson');

            //import
            Route::post('/importData/stocks/xml','ImportExportDataController@xmlToStocks');
            Route::post('/importData/customers/xml','ImportExportDataController@xmlToCustomers');
            Route::post('/importData/suppliers/xml','ImportExportDataController@xmlToSuppliers');




        });

});