<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Utility;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Employee;
use App\Exceptions;
use App\Exceptions\APIException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\CountValidator\Exception;
use App\EmployeeAddress;
use App\EmployeeEmail;
use App\EmployeeTelephone;

class EmployeeController extends Controller
{
    public function get($id)
    {
        try {


            return response()->json(["personal"=>Employee::find($id),"addresses"=>Employee::find($id)->address,'telephones'=>Employee::find($id)->telephone]);

        }
        catch (\Illuminate\Database\QueryException $e){
            return "error";
        }
    }

    public function getAll()
    {
        try {
            return Employee::all();

        }
        catch (\Illuminate\Database\QueryException $e){
            return "error";
        }
    }
    
    public function store(Request $request)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data

        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required',
        );
        $validator = Validator::make(Input::except('telephones','emails','addresses'), $rules); //validate input according to rule above
        $employee = new Employee(Input::except('telephones','emails','addresses'));
        //As data was  send with Dataname that correspond to that in Db ,no need to precise what input goes in what table field(row),(laravel Figure it out)
        $employee->save();
        $employeeId=$employee->id; //Id Of employee created

        $telephones=Input::get('telephones'); //get Telephone Number Array
        //save telephone Number

        foreach ($telephones as $telephone) {
            $employeeTelephone=new employeeTelephone;
            $employeeTelephone->employee_id=$employeeId;
            $employeeTelephone->type=$telephone['type'];
            $employeeTelephone->telephone_number=$telephone['telephone_number'];
            $employeeTelephone->save();
        }

        $addresses=Input::get('addresses');
        //saving Addresses
        foreach ($addresses as $address){
            $employeeAddress=new employeeAddress;
            $employeeAddress->employee_id=$employeeId;
            $employeeAddress->type=$address['type'];
            $employeeAddress->address=$address['address'];
            $employeeAddress->save();

        }

        $emails=Input::get('emails');
        //saving Emails address

        foreach ($emails as $email){
            $employeeEmail=new employeeEmail;
            $employeeEmail->employee_id=$employeeId;
            $employeeEmail->type=$email['type'];
            $employeeEmail->email=$email['email'];
            $employeeEmail->save();

        }


        return  array("successful"=>true, "message"=>"Employee was created");
    }




    public function update($id)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data
        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        $employee = Employee::find($id);
        $employee->update(Input::all());
        return  array("successful"=>true, "message"=>"Employee was updated");

    }


    public function destroy($id)
    {
        //Delete An Employee with id X
        try {
            $employee = Employee::findOrFail($id); //get Customer with id X
           // throw new APIException('Employee Could not be deleted');
            $employee->delete($id); //delete the Customer
          return  array("successful"=>true, "message"=>"Employee was deleted");

        }

        catch (ModelNotFoundException $e) {
            throw new APIException('Employee Not Found');
        }


    }
}
