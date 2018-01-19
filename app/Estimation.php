<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimation extends Model
{
    protected $table="estimations";
    protected $connection = 'tenant';
    protected $guarded = array(['id']);
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
    public function estimationItem()
    {
        return $this->hasMany('App\EstimationItem','estimation_id');
    }
    public function estimationLabour()
    {
        return $this->hasMany('App\EstimationLabour');
    }
}
