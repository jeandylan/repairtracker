<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmail extends Model
{
    protected $table='employee_email';
    protected $fillable = ['email', 'type','employee_id'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
