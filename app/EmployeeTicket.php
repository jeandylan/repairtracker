<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class EmployeeTicket extends Model
{
    protected $table='employee_ticket';
    protected $guarded = array(['id']);
    // protected $fillable = ['ticket_id','employee_id'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
