<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasCompanyDomain extends Model
{
    protected $connection = 'saas_admin';
    protected  $table='company_domain';
    public $timestamps = false; //just for teSTING

    public function companyDomain(){
        return $this->belongsTo('App/SaasCompanyDomain');

    }
}
