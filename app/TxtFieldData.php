<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;

class TxtFieldData extends Model
{
    protected $table='txt_field_data';
    public $timestamps = false; //juat for testing
    protected $fillable = ['field_id','field_data','entity_id'];
    public function property(){
        return $this->belongsTo('App\TxtField', 'field_id');
    }




}
