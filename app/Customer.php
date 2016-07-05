<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{

    protected $fillable = array('first_name', 'last_name', 'email','date_of_birth','home_tel','mobile_tel','mobile_tel_1','address','address_1');
}
