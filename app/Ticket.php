<?php

namespace App;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table='tickets';
    protected  $fillable= array('customer_id', 'model', 'make','problem_type','problem_definition');

    //ticket belong to A Customer
    public function customer(){
        return $this->belongsTo('App\Customer','customer_id');

    }

    public function  invoice(){
        //foreign key,then Local key
        return $this->hasOne('App\Invoice','ticket_id','id');
    }


    function stock1(){
        //2nd arg is pivot table name
        return $this->belongsToMany('App\Stock','stock_ticket','ticket_id','stock_id');
    }
}
