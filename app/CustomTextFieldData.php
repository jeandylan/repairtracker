<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;

class CustomTextFieldData extends Model
{
    use BelongsToTenant;
    protected $table='custom_text_field_data';
    protected $connection = 'tenant';
    public $timestamps = false; //juat for testing
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function property(){
        return $this->belongsTo('App\CustomTextField', 'field_id');
    }
}
