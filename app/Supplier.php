<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class Supplier extends Model
{
    protected $table='suppliers'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    protected $connection = 'tenant';

    public function stocks(){
        return $this->belongsToMany('App\Stock','stock_supplier','supplier_id','stock_id');
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
