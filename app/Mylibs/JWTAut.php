<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 9/13/16
 * Time: 1:29 AM
 */


namespace App\Mylibs;
use Illuminate\Support\Facades\Request;
use Firebase\JWT\JWT;
use App\Employee;
use App\AllEmployee;

class JWTAut
{
    public static function decode (){
        $req= Request::capture();
        $currentToken = $req->bearerToken();
        $key= \Config::get('FirebaseJWT.key'); // default
        $decoded = JWT::decode($currentToken,$key, array('HS256'));
        return (array) $decoded;
    }

    public static function toUser(){
        $tokenData=self::decode();

        return AllEmployee::find($tokenData['iss']);
    }
}