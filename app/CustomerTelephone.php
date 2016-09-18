<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class CustomerTelephone extends Model
{

    protected $table='customer_telephone';
  //  protected $fillable = ['telephone_number', 'type','customer_id'];
    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }
}
