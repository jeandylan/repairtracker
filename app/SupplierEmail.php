<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierEmail extends Model
{
    protected $table='supplier_email';
    protected $fillable = ['email', 'type','supplier_id'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
