<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierTelephone extends Model
{
    use BelongsToTenant;
    protected $table='supplier_telephone';

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
