<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomTextField extends Model
{
    //use BelongsToTenant;  /* use Belong To only if each location have different need for ticket
    protected $table='custom_text_fields';
    protected $connection = 'tenant';
    public $timestamps = false; //just for teSTING
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function fieldData(){
        return $this->hasMany('App\CustomTextFieldData', 'custom_text_field_id', 'id');
    }
}
