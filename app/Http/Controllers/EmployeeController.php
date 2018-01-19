<?php

namespace App\Http\Controllers;
use App\Ticket;
use Firebase\JWT\JWT;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Gmail;
use Illuminate\Http\Request;
use App\Common\Utility;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Employee;
use App\AllEmployee;
use App\Exceptions;
use App\Exceptions\APIException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\CountValidator\Exception;
use App\EmployeeAddress;
use App\EmployeeEmail;
use App\EmployeeTelephone;
use App\Mylibs\JWTAut;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
public function every(){
    return AllEmployee::all();
}

    public function get($id)
    {
        try {
            $employee= Employee::find($id);
            $employeeRole="";
           if ($role=$employee->roles()->first()){
               $employeeRole= $role->name;
           } //add role to output,check if it has not a null role

           return $employee->setAttribute('role',$employeeRole);
        }
        catch (\Illuminate\Database\QueryException $e){
            return "error";
        }

    }

    public function getProfile(){
       $employee= JWTAut::toUser();
        $employee->setAttribute("role",$employee->roles()->pluck('name'));
        return $employee;
    }

    public function getAll()
    {
        try {
            $employees=Employee::all();
            foreach ($employees as $employee){
                $employeeRole="";
                if ($role=$employee->roles()->first()){
                    $employeeRole= $role->name;
                } //add role to output,check if it has not a null role

                $employee->setAttribute('role',$employeeRole);
            }
            return $employees;

        }
        catch (\Illuminate\Database\QueryException $e){
            return "error";
        }
    }
    
    public function store(Request $request)
    {
        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required',
        );
        //$validator = Validator::make(Input::except('telephones','emails','addresses','token'), $rules); //validate input according to rule above

        $employee = new Employee($request->except(['password','role']));
        $employee->password=Hash::make($request->password);
        //As data was  send with Dataname that correspond to that in Db ,no need to precise what input goes in what table field(row),(laravel Figure it out)
        $employee->save();
        return  array("successful"=>true, "message"=>"Employee was created","id"=>$employee->id);
    }





    public function update($id)
    {
        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        $employee = Employee::find($id);
        $employee->update(Input::only('first_name','last_name','email','address','telephone','isActive','date_of_birth'));
        return  array("successful"=>true, "message"=>"Employee details was updated");
        }

        public  function updatePassword($id,Request $request){
            $employee=Employee::find($id);
            $newPassword=Hash::make($request->newPassword);
            $employee->update(['password'=>$newPassword]);
            return  array("successful"=>true, "message"=>"Employee password updated");


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

    public function assignRole(Request $request,$id){
        try {
            $employee = Employee::findOrFail($id); //get Customer with id X
            // throw new APIException('Employee Could not be deleted');
            $role=$employee->roles()->pluck('name');
            if($role){
                $employee->syncRoles([$request->role]);
                return  array("successful"=>true, "message"=>"Employee role was updated");
            }
            else{
                $employee->assignRole($request->role); //role dores not exist Need To create one
                return  array("successful"=>true, "message"=>"Employee role created");
            }
        }

        catch (ModelNotFoundException $e) {
            throw new APIException('Employee Not Found');
        }
    }

    public function searchTechnician(){
        $global=Input::get('global'); //global means anything Here We search both first name and last name
        $companyTechnician=[];
        if($global){
            $employees=Employee::where("last_name", "LIKE", "%$global%")
                ->OrWhere("first_name", "LIKE", "%$global%")->get();
            foreach ($employees as $employee){
                if ($employee->hasRole("technician")){
                    array_push($companyTechnician,$employee);
                }
            }
        }
        return $companyTechnician;
    }

    public  function  getTechnician(){ //search for employee assign role Technician with help of spartie role permission
       $employees=Employee::all();
        $companyTechnician=[];
        foreach ($employees as $employee){
            if ($employee->hasRole("technician")){
                array_push($companyTechnician,$employee);
            }
        }
        return $companyTechnician;


    }

}
