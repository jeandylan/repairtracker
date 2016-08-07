<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTelephone extends Model
{
    protected $table='employee_telephone';
    protected $fillable = ['telephone_number', 'type','employee_id'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
