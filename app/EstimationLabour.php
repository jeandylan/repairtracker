<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimationLabour extends Model
{
      protected $table="estimation_labour";
    protected $fillable = ['name','cost'];
    protected $guarded = array(['id']);
    public function estimation()
    {
        return $this->belongsTo('App\Estimation');
    }

}
