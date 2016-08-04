<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerEmail extends Model
{
    protected $table='customer_email';
    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }
}
