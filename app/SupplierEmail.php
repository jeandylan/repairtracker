<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class SupplierEmail extends Model
{
    use BelongsToTenant;
    protected $table='supplier_email';
    protected $fillable = ['email', 'type','supplier_id'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
