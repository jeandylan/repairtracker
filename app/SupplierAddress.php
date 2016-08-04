<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    protected $table='supplier_address';
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
