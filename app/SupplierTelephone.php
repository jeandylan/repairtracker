<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierTelephone extends Model
{
    use BelongsToTenant;
    protected $table='supplier_telephone';
    protected $fillable = ['telephone_number', 'type','supplier_id'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
