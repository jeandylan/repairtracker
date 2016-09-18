<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;

class StockLocationLevel extends Model
{
    use BelongsToTenant;
    protected  $table='stocks_location_level';
    protected $guarded = array(['id']);

    public function stock(){
        $this->hasOne('App\Stock','stock_id');
    }
}
