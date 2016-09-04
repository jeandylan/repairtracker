<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class EmployeeEmail extends Model
{
    use BelongsToTenant;
    protected $table='employee_email';
    protected $fillable = ['email', 'type','employee_id'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
