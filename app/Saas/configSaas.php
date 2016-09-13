<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 9/7/16
 * Time: 12:49 AM
 */

use Illuminate\Support\Facades\DB;
use Schema;
use Illuminate\Support\Facades\Artisan;

function configureConnectionByName($tenantName)
{
    // Just get access to the config.
    $config = App::make('config');

    // Will contain the array of connections that appear in our database config file.
    $connections = $config->get('database.connections');

    // This line pulls out the default connection by key (by default it's `mysql`)
    $defaultConnection = $connections[$config->get('database.default')];

    // Now we simply copy the default connection information to our new connection.
    $newConnection = $defaultConnection;
    // Override the database name.
    $newConnection['database'] = $tenantName;

    // This will add our new connection to the run-time configuration for the duration of the request.
    App::make('config')->set('database.connections.'.$tenantName, $newConnection);

}

function createSchema($schemaName)
{
    // We will use the `statement` method from the connection class so that
    // we have access to parameter binding.




    //Artisan::call('migrate',['--path'=>'database/migrations/tenants']);
   // \Config::set('database.connections.mysql.database', 'saas_admin'); //use database associated with company

}
