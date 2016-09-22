<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimationItem extends Model
{
    protected $table="estimation_item";
    protected $fillable = ['estimation_id','stock_id','product_name','qty_out','selling_price'];
    protected $guarded = array(['id']);
    public function estimation()
    {
        return $this->belongsTo('App\Estimation');
    }

}
