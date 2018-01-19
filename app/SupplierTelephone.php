<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierTelephone extends Model
{

    protected $table='supplier_telephone';
    protected $connection = 'tenant';

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
