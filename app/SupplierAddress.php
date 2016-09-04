<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierAddress extends Model
{
    use BelongsToTenant;
    protected $table='supplier_address';
    protected $fillable = ['address', 'type','supplier_id'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
