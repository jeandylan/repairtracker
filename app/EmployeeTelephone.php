<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\BelongsToTenant;
class EmployeeTelephone extends Model
{
    use BelongsToTenant;
    protected $table='employee_telephone';
  //  protected $fillable = ['telephone_number', 'type','employee_id'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
