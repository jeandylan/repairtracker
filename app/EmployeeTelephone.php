<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTelephone extends Model
{
    protected $table='employee_telephone';
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
