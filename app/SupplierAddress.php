<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierAddress extends Model
{
    protected $table='supplier_address';
    protected $connection = 'tenant';
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
