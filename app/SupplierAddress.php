<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierAddress extends Model
{
    use BelongsToTenant;
    protected $table='supplier_address';
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
