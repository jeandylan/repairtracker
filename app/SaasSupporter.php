<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaasSupporter extends Model
{

    protected  $table='saas_supporter';
    protected $fillable = ['name','email','clients','status'];
    public $timestamps = true;
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign

}
