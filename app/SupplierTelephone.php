<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierTelephone extends Model
{
    protected $table='supplier_telephone';
    protected $fillable = ['telephone_number', 'type','supplier_id'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
