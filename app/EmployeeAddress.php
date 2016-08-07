<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    protected $table='employee_address';
 
    protected $fillable = ['address', 'type','employee_id'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
