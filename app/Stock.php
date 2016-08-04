<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table='stocks'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    function suppliers(){
        //2nd arg is pivot table name
       // return $this->belongsToMany('App\Supplier','stock_supplier','supplier_id','stock_id');

        return $this->belongsToMany('App\Supplier','stock_supplier','stock_id','supplier_id');
    }
    
    function tickets(){
        //2nd arg is pivot table name
        return $this->belongsToMany('App\Ticket','stock_ticket','stock_id','ticket_id');
    }



}
