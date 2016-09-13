<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomTextFieldData extends Model
{
    protected $table='custom_text_field_data';
    public $timestamps = false; //juat for testing
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function property(){
        return $this->belongsTo('App\CustomTextField', 'field_id');
    }
}
