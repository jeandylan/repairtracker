<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Employee;
class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            /*Bug In library force me to follow such technique*/
            $received_token  = JWTAuth::getToken();
            $decodeToken=JWTAuth::decode($received_token)->get();
            $employee=Employee::where('email',$decodeToken['sub'])->first();

            //check if employee exist else Return Error
            if ($employee && $employee->password==$decodeToken['password']){
                return $next($request);
            }
            else{
                return response()->json(['successful' => 'false', 'message' => 'credential invalid']);
            }
            /*make it more Secure Fresh Token every time*/
            // $newToken          = JWTAuth::refresh($current_token);

        }
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

    }
}
