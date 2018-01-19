<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasMessages extends Model
{

    protected  $table='saas_messages';
    protected $fillable = ['name','email','subject','message','status'];
    public $timestamps = true;
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign

}
