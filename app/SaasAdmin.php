<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasAdmin extends Model
{
    protected  $table='saas_admin';
    public $timestamps = false;

     function login($email,$password){
        $admin= $this->where('email','=',$email)->where('password','=',$password);

         if ($admin) $admin;
         if(!$admin) return False;
     }
}
