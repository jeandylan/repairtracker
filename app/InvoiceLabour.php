<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLabour extends Model
{
    protected $table='invoice_labour'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function invoice() {
        return $this->belongsTo('App\Invoice','invoice_id');
    }
}
