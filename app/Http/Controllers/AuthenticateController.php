<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use App\Employee;
use Tymon\JWTAuth\Exceptions\JWTException;
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
                   $token = JWTAuth::fromUser($employee,$customClaims);
                   return array("successful"=>true, "message"=>"login sucessful","token"=>$token);
               }
               return response()->json(['error' => 'invalid_password'], 401);

            }
            else{
                return response()->json(['error' => $request->input('email')], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


    }




}
