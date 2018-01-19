<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
use Spatie\Permission\Traits\HasRoles;
class Employee extends Model
{

    protected $table='employees'; //tbl Model refers to
    protected $connection = 'tenant';
    protected $guarded = array(['id']); //cannot be updated ,by mass Assign
    use BelongsToTenant;
    use HasRoles;

    public function  task(){
        return $this->hasMany('App\EmployeeTicket','employee_id');
    }

    public function ticket(){  ///Depreciated
        return $this->belongsToMany('App\Ticket','employee_ticket','employee_id','ticket_id');
    }
    public function taskNotification(){
        return $this->task()->where('read','=',0);
    }
    public function readAllNotificationTicket(){
        $tasks=$this->taskNotification()->get();
        foreach ($tasks as $task) {
            $task->update(['read'=>1]);
            $task->save();

         }
    }






}
