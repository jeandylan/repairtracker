<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockLocationCreator extends Model
{
    // the creator do not use the belong to function basically the same as StockLocation
    protected  $table='stocks_location_level';
    protected $connection = 'tenant';
    protected $guarded = array(['id']);

    public function stock(){
        $this->hasOne('App\Stock','stock_id');
    }
}
