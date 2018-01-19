<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;

class StockLocationLevel extends Model
{
    use BelongsToTenant;
    protected  $table='stocks_location_level';
    protected $connection = 'tenant';
    protected $guarded = array(['id']);

    public function stock(){
        return $this->belongsTo('App\Stock','stock_id');
    }
}
