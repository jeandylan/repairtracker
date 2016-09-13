<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class CustomerAddress extends Model
{

    protected $table='customer_address';
    protected $fillable = ['address', 'type','customer_id'];

    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }
}
