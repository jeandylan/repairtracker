<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class StockTicket extends Model
{
    use BelongsToTenant;
    protected $table='stock_ticket'; //tbl Model refers to
}
