<?php

namespace App\Http\Controllers\SaasAdmin;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use League\Flysystem\Exception;
use Validator;
use \Firebase\JWT\JWT;
use App\SaasAdmin;
use Illuminate\Support\Facades\Artisan;
use Schema;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use App\SaasCompany;
use App\SaasCompanyLocation;

class CompanyController extends Controller
{


    public function all()
    {
        return SaasCompany::all();
    }

    public function companyDomain($companyId)
    {
        return SaasCompany::find($companyId)->companyLocation()->get();
    }


    public function login(Request $request)
    {
        // grab credentials from the request
        try {

            if ($employee = SaasAdmin::where('email', $request->input('email'))->get()->first()) {
// if(Hash::check($request->input(['password']), $employee->password))
                if ($request->input(['password']) == $employee->password) {
                    $customClaims = ['password' => $employee->password];
                    $key = \Config::get('FirebaseJWT.key'); // default
                    $token = array(
                        'data' => "ujuh",          // Data related to the signer user
                        "iss" => $employee->id,
                        "jti" => base64_encode(time()),
                        "aud" => "repairTracker",
                        "iat" => time(),
                        "nbf" => time() + 10,
                        "exp" => time() + 600500,
                        "nbf" => time(),
                        "data" => $customClaims
                    );
                    $token = JWT::encode($token, $key, 'HS256');
                    return array("successful" => true, "message" => "login sucessful", "token" => $token);
                }
                return response()->json(['error' => 'invalid_password'], 401);

            } else {
                return response()->json(['error' => $request->input('email')], 401);
            }
        } catch (Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


    }

    public function createCompany(Request $request){
        $company = new SaasCompany($request->input('company_details'));
        $company->save();
        $companyLocations=$request->input('company_location');
        $domainName='saasrepair1.xyz';

        /*create Default Asmin*/
        $saasCompanyLocation =new SaasCompanyLocation();
        $saasCompanyLocation->saas_company_id=$company->id;
        $saasCompanyLocation->location_hostname="admin".".".$company->company_name.".".$domainName;
        $saasCompanyLocation->isAdmin=1;
        $saasCompanyLocation->isActive=1;
        $saasCompanyLocation->save();

        /*iterate tru each location given*/
        foreach ($companyLocations as $companyLocation){
            $saasCompanyLocation =new SaasCompanyLocation();
            $saasCompanyLocation->saas_company_id=$company->id;
            $saasCompanyLocation->location_hostname=$companyLocation['location_hostname'].".".$company->company_name.".".$domainName;
            $saasCompanyLocation->isAdmin=1;
            $saasCompanyLocation->isActive=1;
            $saasCompanyLocation->save();
        }


        \DB::statement('create database ' . $company->company_name); //create Db
        \DB::purge('mysql'); //delete mysql cache first to prevent obtain the previous  database connection datas
        \Config::set('database.connections.mysql.database', $company->company_name); //the location name ===the databse name

        \Artisan::call('migrate');
        //create the super aDMIN
        $password=Hash::make( $request->input('company_details.password')); //password customer provided

        DB::insert('insert into employees ( first_name,last_name,date_of_birth,email,password,shop_location) values (?,?,?,?,?,?)',
            [$company->owner_first_name, $company->owner_last_name,$company->date_of_birth,$company->email,$password,"all"]);
        //create roles

        DB::insert('insert into roles ( name) values (?)',
            ["technician"]);
        DB::insert('insert into roles ( name) values (?)',
            ["admin"]);
        DB::insert('insert into roles ( name) values (?)',
            ["superAdmin"]);
        DB::insert('insert into user_has_roles ( role_id,employee_id) values (?,?)',
            [3,1]);

        DB::insert('insert into shop_customization (invoice_email_header) values(?)',["effer"]);

        //rtoles
        DB::insert('insert into permissions (name) values (?)',['view dashboard']);
        DB::insert('insert into permissions (name) values (?)',['view calendar']);
        DB::insert('insert into permissions (name) values (?)',['view stock']);
        DB::insert('insert into permissions (name) values (?)',['view ticket']);
        DB::insert('insert into permissions (name) values (?)',['view all employees']);
        DB::insert('insert into permissions (name) values (?)',['view location employees']);
        DB::insert('insert into permissions (name) values (?)',['view supplier']);
        DB::insert('insert into permissions (name) values (?)',['view import data']);
        DB::insert('insert into permissions (name) values (?)',['view export data']);
        DB::insert('insert into permissions (name) values (?)',['view setting']);

        //assign permissio to roles

        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[3,1]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[4,1]);

        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[2,2]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[6,2]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[7,2]);

        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[1,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[2,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[3,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[4,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[5,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[6,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[7,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[8,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[9,3]);
        DB::insert('insert into role_has_permissions (permission_id, role_id) values (?,?)',[10,3]);






        \Config::set('database.connections.mysql.database', "saas"); //the location name ===the databse name,change back to default

        return  array("successful"=>true, "message"=>"customer was created","newResource"=>$company);

    }


    public function updateCompany($id,Request $request){
        $company=SaasCompany::find($id);
        $company->update($request->all());
        return  array("successful"=>true, "message"=>"company was created");

    }

    public  function getCompany($id){
        return SaasCompany::find($id);
    }
    public function deleteCompany($id){
        $company=SaasCompany::find($id);
        $company->delete();
        return  array("successful"=>true, "message"=>"company was created");
    }

    /*companyLocation function*/

    public  function getCompanyLocations($companyId){
        $company= SaasCompany::find($companyId);
        $companyLocation= $company->companyLocation()->get();
        return $companyLocation;
    }

    public  function getActiveCompanyLocationsByName($companyName){
        $company= SaasCompany::where('company_name','=',$companyName)->where('isActive','=',true)->first();
        $companyLocation= $company->companyLocation()->get();
        return $companyLocation;
    }

    public function  updateCompanyLocation($id,Request $request){
        $domainName='saasrepair1.xyz'; ///should be updated to server Domain name when poted online
        $saasCompanyLocation=SaasCompanyLocation::find($id);
        $company=$saasCompanyLocation->company()->get();
        $saasCompanyLocation->saas_company_id=$company->id;
        $saasCompanyLocation->location_hostname=$request->location_hostname.".".$company->company_name.".".$domainName;
        $saasCompanyLocation->isAdmin=$request->isAdmin;
        $saasCompanyLocation->isActive=$request->isActive;

        return  array("successful"=>true, "message"=>"company location was Update");

    }

    public  function createCompanyLocation($companyId,Request $request){
        $company=SaasCompany::find($companyId);
        $company->companyLocation()->create($request->all());
        return  array("successful"=>true, "message"=>"location created");
    }


    public function deleteCompanyLocation($id){
        $company=SaasCompanyLocation::find($id);
        $company->delete();
        return  array("successful"=>true, "message"=>"company location was created");
    }

    public function payment(Request $request){

        \Stripe\Stripe::setApiKey("sk_test_ONhQDO3ZbbrhrWDg6JiGeZjY");

        $token = $request->token;

// Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 1000, // Amount in cents
                "currency" => "usd",
                "source" => $token,
                "description" => "Example charge"
            ));
            return  array("successful"=>true, "message"=>"you were charged");
        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
        }
    }
}

/*function register(Request $request){

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
   */