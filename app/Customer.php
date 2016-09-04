<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;

class Customer extends Model
{
    use BelongsToTenant;
    protected $table='customers';
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    //protected $fillable = array('first_name', 'last_name', 'email','date_of_birth','home_tel','mobile_tel','mobile_tel_1','address','address_1'); //white List

    //user can have many Tickets
    public function tickets(){
        return $this->hasMany('App\Ticket','customer_id');
    }

    public function invoices(){
        //final Model,Intermediate Model,foreignKey Intermediade Model,foreign key Final Model
        return $this->hasManyThrough('App\Invoice','App\Ticket','customer_id','ticket_id');
    }
    public function address()
    {
        return $this->hasMany('App\CustomerAddress');
    }

    public function email(){
        return $this->hasMany('App\CustomerEmail');
    }
     public  function telephone(){
         return $this->hasMany('App\CustomerTelephone');
     }

}