<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TxtField extends Model
{
    protected $table='txt_fields';
    public $timestamps = false; //just for teSTING
    protected $fillable = ['field_name', 'required','max','form_name'];
    public function data(){
        return $this->hasMany('App\TxtFieldData', 'field_id', 'id');
    }
    
}
