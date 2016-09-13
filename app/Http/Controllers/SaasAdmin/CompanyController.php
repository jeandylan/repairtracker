<?php

namespace App\Http\Controllers\SaasAdmin;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use League\Flysystem\Exception;
use Validator;
use Illuminate\Support\Facades\Artisan;
use Schema;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    function register(Request $request){

      DB::table('company')->insert(
            ['company_name' => $request->company_name,
                'owner_first_name'=>$request->owner_first_name,
                'owner_last_name'=>$request->owner_last_name,
                'owner_password'=>Hash::make($request->owner_password),
                'owner_email'=>$request->owner_email]
        );
       // exec("python /var/www/html/repairtracker/domainCreator.py -vd saas.$request->company_name.admin.mu"); //create company Admin Domain
       // exec("python /var/www/html/repairtracker/domainCreator.py -vd saas.$request->company_name.$request->company_location_1.mu");
       // exec("python /var/www/html/repairtracker/domainCreator.py -vd saas.$request->company_name.$request->company_location_2.mu");

        //create Location One (this is subject to improvement by Asheef)
        DB::table('company_domain')->insert(
            ['company_name' => $request->company_name,
                'domain_name'=>$request->company_name.".".$request->company_location_1.".saasrepair.cc",
                'location'=>$request->owner_location_1]
        );
//create Location2 for asheef to improve
        DB::table('company_domain')->insert(
            ['company_name' => $request->company_name,
                'domain_name'=>$request->company_name.".".$request->company_location_2.".saasrepair.cc",
                'location'=>$request->owner_location_2]
        );

       // $this->create($request->company_name);
        //$this->createOneAdmin($request);

        return (array('admin'=>"saas.".$request->company_name.".admin.mu",
            "locations"=>array("saas.".$request->company_name.".".$request->company_location_1.".mu",
                "saas.".$request->company_name.".".$request->company_location_2.".mu"),
            "created Employee at "=>'saas.'.$request->company_name.".".$request->company_location_1.".mu",
            "employee Email "=>$request->owner_email,
            "password "=>$request->owner_password
            ));





    }

    function createOneAdmin($request){
        \DB::purge('mysql'); //delete Previous MYSQL cache to prevent Madness ,before Switchng Connection
        \Config::set('database.connections.mysql.database', $request->company_name); //use database associated with company
        DB::table('employees')->insert([
                'first_name'=>$request->owner_first_name,
                'last_name'=>$request->owner_last_name,
                'password'=>Hash::make($request->owner_password),
                'role'=>"admin",
                'email'=>$request->owner_email,
                'date_of_birth'=>"1997-08-15",
                'shop_location'=>$request->company_location_1

            ]);
        \DB::purge('mysql'); //delete Previous MYSQL cache to prevent Madness
        \Config::set('database.connections.mysql.database', 'saas_admin'); //use database associated with company
    }

    function create($companyName){

        \Config::set('database.connections.mysql.database', 'saas_admin'); //make use to use the Our Main admin db , to check whatvever need to be checked
        try {
            DB::connection()->statement('CREATE DATABASE '.$companyName);
            \DB::purge('mysql'); //delete Previous MYSQL cache to prevent Madness ,before Switchng Connection
            \Config::set('database.connections.mysql.database', $companyName); //use database associated with company
            Artisan::call('migrate',['--path'=>'database/migrations/tenants']);
            \DB::purge('mysql'); //delete Previous MYSQL cache to prevent Madness,before Switching Back To Main Admin
            \Config::set('database.connections.mysql.database', 'saas_admin'); //use database associated with company
        }
        catch (QueryException $e){
            if($e->getCode()=='HY000') {
                \DB::purge('mysql'); //delete Previous MYSQL cache to prevent Madness
                \Config::set('database.connections.mysql.database', 'saas_admin'); //use database associated with company

                return "company name not unique, call Us We Will be happy to solve the issue";

            }
            return "err";

        }

    }
}
