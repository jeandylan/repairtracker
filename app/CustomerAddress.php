<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $table='customer_address';
    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }
}
