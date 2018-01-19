<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    protected $table='tickets_comments';
    protected $connection = 'tenant';

    public function  author(){
       return $this->belongsTo('App\Employee');
    }

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }
}
