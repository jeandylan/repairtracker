<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasCompanyLocation extends Model
{
    protected  $table='saas_company_location';
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public $timestamps = false;


    public function company(){
        return $this->belongsTo('App\SaasCompany','saas_company_id');

    }


    public function  isValid(){ //return T or f
       if(!$company= $this->company()->first()) return "invalidcompany";
           if(!$company->isActive)return "duePayment";
        return "valid";
    }



}
