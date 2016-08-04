<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    protected $table='employee_address';
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
