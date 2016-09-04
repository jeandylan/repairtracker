<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class Employee extends Model
{
    use BelongsToTenant;
    protected $table='employees'; //tbl Model refers to
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    public function address()
    {
        return $this->hasMany('App\EmployeeAddress');
    }
    public function email(){
        return $this->hasMany('App\EmployeeEmail');
    }
    public  function telephone(){
        return $this->hasMany('App\EmployeeTelephone');
    }

    public function ticket(){
        return $this->belongsToMany('App\Ticket','employee_ticket','employee_id','ticket_id');
    }



}
