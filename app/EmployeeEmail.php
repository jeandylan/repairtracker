<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmail extends Model
{
    protected $table='employee_email';
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
