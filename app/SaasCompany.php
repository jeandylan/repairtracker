<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasCompany extends Model
{
    protected $connection = 'saas_admin';
    protected  $table='company';
    protected $primaryKey = 'company_name'; // or null
    public $timestamps = false; //just for teSTING

    public $incrementing = false;

    public function companyDomain(){
        return $this->hasMany('App/SaasCompanyDomain');

    }
}
