<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class StockSupplier extends Model
{
    use BelongsToTenant;
    protected $table='stock_supplier'; //tbl Model refers to
    
    
}
