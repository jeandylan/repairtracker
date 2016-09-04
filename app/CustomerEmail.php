<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class CustomerEmail extends Model
{
    use BelongsToTenant;
    protected $fillable = ['email', 'type','customer_id'];
    protected $table='customer_email';
    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }
}
