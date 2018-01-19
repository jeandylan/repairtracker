<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class Invoice extends Model
{
    protected $table='invoices'; //tbl Model refers to
    protected $connection = 'tenant';
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function ticket() {
        return $this->belongsTo('App\Ticket','ticket_id'); // this matches the Eloquent model Name
    }
    public  function labour(){
        return $this->hasMany('App\InvoiceLabour','invoice_id','id');
    }
   
}
