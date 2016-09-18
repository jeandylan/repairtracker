<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class EmployeeAddress extends Model
{
    use BelongsToTenant;
    protected $table='employee_address';
 
  //  protected $fillable = ['address', 'type','employee_id'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
