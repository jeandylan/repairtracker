<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerTelephone extends Model
{
    protected $table='customer_telephone';
    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }
}
