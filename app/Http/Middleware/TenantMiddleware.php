<?php

namespace App\Http\Middleware;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Closure;
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
        /* uncomment on production
        $serverName=Request::server ("SERVER_NAME"); //obtain the full server name request
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
        \Landlord::addTenant('shop_location', 'mahebourg'); //use shop location of company to get/set data in db for specific shop location
        return $next($request);

    }
}

//TODO set db connection on production