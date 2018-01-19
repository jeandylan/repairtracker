<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierEmail extends Model
{
    protected $table='supplier_email';
    protected $connection = 'tenant';
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
