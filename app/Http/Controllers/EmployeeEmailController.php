<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\EmployeeEmail;

class EmployeeEmailController extends Controller
{
    public function store(){
        $rules = array(
            'type'       => 'required',
            'email'      => 'required',
            'employee_id' =>'required'
        );
        $validationMessages = [
            'type.required' => 'email Type not given',
            'email.required' => 'email details not given',
            'employee_id.required' => 'employee_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $employeeEmail= new EmployeeEmail(Input::all());
            $employeeEmail->save();
            return response()->json(["successful"=>true, 'message' => 'email Created Sucessful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }
    }

    public function update(Request $request, $id)
    {
        $email=EmployeeEmail::find($id);
        if($email != null) {
            $email->update(Input::all());
            return response()->json(["successful"=>true, 'message' => 'email Update Sucessful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' => 'email Cannot be Updated unsaved/unKnown']);
        }

    }
    public function destroy($id)
    {
        $email = EmployeeEmail::find($id); //get Customer with id X
        if ($email != null) {
            $email->delete($id); //delete the email
            return array("successful"=>true, "message"=>"email was deleted");
        }
        else{
            return array("successful"=>false, "message"=>"deleting unknown Email");
        }




    }
}
