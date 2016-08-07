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

            $employee= Employee::find($id);
            return ($employee != null) ? response()->json(['successful'=>true,'personal' => $employee, 'addresses' => $employee->address()->get(),'telephones'=>$employee->telephone()->get(),'emails'=>$employee->email()->get()]):
                response()->json(['successful'=>false,'message'=>'cannot find employee']);


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

        $addresses=Input::get('addresses');
        foreach ($addresses as $address) $employee->address()->create($address);

        $telephones=Input::get('telephones'); //get Telephone Number Array
        foreach ($telephones as $telephone) $employee->telephone()->create($telephone);

        $emails=Input::get('emails');
        foreach ($emails as $email) $employee->email()->create($email);


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
        $employee->update(Input::only('first_name','last_name','role'));
        return  array("successful"=>true, "message"=>"Employee details was updated");
        }
/*
        $emails=Input::get('emails');
        foreach ($emails as $email){
            if(isset($email['id'])) EmployeeEmail::find($email['id'])->update($email);
        }
        $telephones=Input::get('telephones');
        foreach ($telephones as $telephone){
            if(isset($telephone['id'])) EmployeeTelephone::find($telephone['id'])->update($telephone);
        }




    }
*/


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
