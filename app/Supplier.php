<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table='suppliers'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign

    public function stocks(){
        return $this->hasMany('App\Ticket','customer_id');
    }
}
