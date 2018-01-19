<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimationLabour extends Model
{
      protected $table="estimation_labour";
    protected $connection = 'tenant';
    protected $fillable = ['name','cost','estimation_id'];
    protected $guarded = array(['id']);
    public function estimation()
    {
        return $this->belongsTo('App\Estimation');
    }

}
