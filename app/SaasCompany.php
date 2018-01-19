<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasCompany extends Model
{

    protected  $table='saas_company';
    protected $fillable = ['owner_first_name','owner_last_name','max_customers','max_employee','company_name',
        'isActive','date_of_birth','email','valid_until','price_per_month'];
    public $timestamps = false;
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign

    public function companyLocation(){
        return $this->hasMany('App\SaasCompanyLocation');

    }

}
