<?php

namespace App;
use App\Customer;
use Illuminate\Database\Eloquent\Model;
use App\CustomTextField;
Use App\CustomTextFieldData;
use App;
use App\TicketComment;
use HipsterJazzbo\Landlord\BelongsToTenant;
class Ticket extends Model
{
    use BelongsToTenant;
    protected $table='tickets';
    protected $guarded = array(['id']);

    //ticket belong to A Customer
    public function customer(){
        return $this->belongsTo('App\Customer','customer_id','id');

    }

    public function  invoice(){
        //foreign key,then Local key
        return $this->hasOne('App\Invoice','ticket_id','id');
    }


    public function stock(){ //we will get The Id Of stock_ticket, so as to update Easily
        //2nd arg is pivot table name
        return $this->hasMany('App\StockTicket');
    }
    public function stockOnly(){ //get only stock associated no stock_ticket  Id,can be used to calculate Invoice
        return $this->belongsToMany('App\Stock','stock_ticket','ticket_id','stock_id');
    }
    public function employee(){
        //2nd arg is pivot table name
        return $this->belongsToMany('App\Employee','employee_ticket','ticket_id','employee_id');
    }
    public  function employeeTask(){
        return $this->hasMany('App\EmployeeTicket','ticket_id');
    }
    public function  technician(){
        return $this->hasMany('App\EmployeeTicket');
    }

    public function estimation(){
      return  $this->hasOne('App\Estimation','ticket_id','id');
    }

    /*
    public function comments(){
        return $this->hasMany('TicketComment');
    }
    */






    public function customTextFieldDetails($ticketId){

        $customFormFields=App\CustomTextField::where('form_name', '=', 'ticket')->get();
        $out=array();
        foreach ($customFormFields as $customFormField){
            $customFieldData=App\CustomTextFieldData::where('entity_id','=',$ticketId)->where('custom_text_field_id','=',$customFormField->id);

           array_push($out,array('data'=>$customFieldData->get(),'properties'=>$customFormField));
        }
        return $out;
    }

    public function fieldPropertyInfo($field_id){
    $fieldInfo=App\CustomTextFieldData::find($field_id)->property()->get();
        //echo  $fieldInfo;
    return $fieldInfo;

}

}
/*
 * php artisan tinker
 */