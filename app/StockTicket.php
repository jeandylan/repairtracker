<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class StockTicket extends Model
{
    protected $fillable =  ['qty_out', 'shop_location', 'ticket_id', 'stock_id', 'created_at', 'updated_at'];
    protected $table='stock_ticket'; //tbl Model refers to
    protected $connection = 'tenant';
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
