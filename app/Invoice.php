<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table='invoices'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function ticket() {
        return $this->belongsTo('App\Ticket','ticket_id'); // this matches the Eloquent model Name
    }
   
}
