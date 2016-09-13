<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;

use Carbon\Carbon;
use App\Employee;
use App\Http\Requests;

class AuthenticateController extends Controller
{

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        try {
            if ($employee=Employee::where('email',$request->input('email'))->get()->first()) {

               if(Hash::check($request->input(['password']), $employee->password)){
                   $customClaims = ['password' =>$employee->password];
                   $key= \Config::get('FirebaseJWT.key'); // default
                   $token = array(
                       'data' =>  "ujuh",          // Data related to the signer user
                       "iss" => $employee->id,
                       "jti"=>base64_encode(time()),
                       "aud" => "repairTracker",
                       "iat" =>  time(),
                       "nbf"=>time()+10,
                       "exp"=>time()+600500,
                       "nbf" => time(),
                       "data"=>$customClaims
                   );
                   $token = JWT::encode($token, $key,'HS256');
                   return array("successful"=>true, "message"=>"login sucessful","token"=>$token);
               }
               return response()->json(['error' => 'invalid_password'], 401);

            }
            else{
                return response()->json(['error' => $request->input('email')], 401);
            }
        } catch (Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


    }




}
