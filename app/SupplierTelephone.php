<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierTelephone extends Model
{
    protected $table='supplier_telephone';
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
