<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class Supplier extends Model
{
    use BelongsToTenant;
    protected $table='suppliers'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign

    public function stocks(){
        return $this->hasMany('App\Ticket','customer_id');
    }

    public function address()
    {
        return $this->hasMany('App\SupplierAddress');
    }
    public function email(){
        return $this->hasMany('App\SupplierEmail');
    }
    public  function telephone(){
        return $this->hasMany('App\SupplierTelephone');
    }
}
