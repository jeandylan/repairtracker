<?php

namespace App\Http\Middleware;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Closure;
use App\Customer;
use App\AllEmployee;
use App\SaasCompanyLocation;
use HipsterJazzbo\Landlord\BelongsToTenant;
class TenantMiddleware
{
    /**
     * as each company have separate database each of these  containing  Identical tbl name,colunms name,separation
     * is done because of good data separation, company can have 1 or more location e.g port louis shop,mahebourg
     * to identify different company  and different shop location Virtualhost name will be used
     * each company have a unique address on server and subdomain for location e.g
     * www.OurSAASHOST.theCompanyName.theCompanyShopLocation.com
     */

    public function handle($request, Closure $next)
    {


        $domainName=Request::server ("HTTP_HOST");
        if ($domainName=='admin.saasrepair1.xyz'){ //if saas.admin means that we are the admin owner,no need to check if domain is valid/payment done etc....
            return $next($request);;
        }

        else {

            if ($SaasCompanyDomain = SaasCompanyLocation::where('location_hostname', '=', $domainName)->first()) {
                if(!$SaasCompanyDomain->isActive) return view('locationFreez'); //when a location have been freez
                $isValid = $SaasCompanyDomain->isValid(); //is company Subscription Valid
                if ($isValid=="valid") {
                    $company = $SaasCompanyDomain->company()->first();
                    $maxNoCustomer=$company->max_customers;
                    $maxNoEmployees=$company->max_employees;
                    \DB::purge('mysql'); //delete mysql cache first to prevent obtain the previous  database connection datas
                    \DB::purge('tenant'); //delete mysql cache first to prevent obtain the previous  database connection datas
                    \Config::set('database.connections.tenant.database', $company->company_name); //the location name ===the databse name
                    if ($request->isMethod('post')) {
                     if(!$this->canAddCustomer($request,$maxNoCustomer)) return response()->json(['error' =>"you need to buy more customer"], 404);
                        if(!$this->canAddEmployee($request,$maxNoEmployees))return response()->json(['error' =>"you need to buy more Employees"], 404);
                    }

                    \Landlord::addTenant('shop_location', $domainName); //use shop location of company to get/set data in db for specific shop location
                    return $next($request);
                }
                if ($isValid == "invalidcompany") {
                    return "wrong Company Db error";
                }
                if ($isValid == "duePayment") {
                    return view('oweMoney');
                }
            }
            else {
                return view('badTenant');
            }
        }

    }

    public function canAddCustomer($request,$maxNoCustomers){
        $uri = $request->path();
        $maxCustomersLimitedRoute=['api/customer'];
        if (in_array($uri, $maxCustomersLimitedRoute)) {
           $currentNoCustomers=Customer::all()->count();
            return ( $maxNoCustomers > $currentNoCustomers);
        }
        return true;

    }

    public function canAddEmployee($request,$maxNoEmployees){
        $uri = $request->path();
        $maxEmployeesLimitedRoute=['api/employee','api/allEmployee'];
        if (in_array($uri, $maxEmployeesLimitedRoute)) {
            $currentNoEmployees=AllEmployee::all()->count();
            return ( $maxNoEmployees > $currentNoEmployees);
        }
        return true;

    }




}










        /*
        // by client and which have been served by virtual host name from apache server

        $serverNameProperties= explode(".", $serverName); //break the sever name(because address are separated by .) into an array as follows
        // array[0] hostDomainName, array[1] subDomain1 i.e company Name, array[2] subDomain2 i.e  locationOfShop array[3] topLevel domain

       // $ar=array('repairtracker','repairtest');


        \DB::purge('mysql'); //delete mysql cache first to prevent obtain the previous  database connection datas

      \Config::set('database.connections.mysql.database',$serverNameProperties[1] ); //use database associated with company

        if(isset($serverNameProperties[2])) { //if shop have location  load specific location data
            \Landlord::addTenant('shop_location', $serverNameProperties[2]); //use shop location of company to get/set data in db for specific shop location
        }

        if ($serverName=='saas.admin'){
            \Config::set('database.connections.mysql.database', 'saas_admin'); //use database associated with company

        }
        */




//TODO set db connection on production