<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\EmployeeTelephone;
use App\Http\Requests;

class EmployeeTelephoneController extends Controller
{
    public function store(){
        $rules = array(
            'type'       => 'required',
            'telephone_number'      => 'required',
            'employee_id' =>'required'
        );
        $validationMessages = [
            'type.required' => 'telephone Type not given',
            'telephone_number.required' => 'telephone number not given',
            'employee_id.required' => 'employee_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $employeeTelephone= new EmployeeTelephone(Input::all());
            $employeeTelephone->save();
            return response()->json(["successful"=>true, 'message' => 'telephone Created Sucessful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }
    }

    public function update(Request $request, $id)
    {
        $telephone=EmployeeTelephone::find($id);

        if ($telephone != null) {
            $telephone->update(Input::all());
            return response()->json(["successful" => true, 'message' => 'telephone Update Sucessful']);
        }
        else{
            return array("successful"=>false, "message"=>"updating  unknown/unsaved Telephone");
        }
    }
    public function destroy($id)
    {
        $telephone = EmployeeTelephone::find($id); //get Customer with id X
        if ($telephone != null) {
            $telephone->delete($id); //delete the email
            return array("successful"=>true, "message"=>"email was deleted");
        }
        else{
            return array("successful"=>false, "message"=>"deleting unknown/unsaved Telephone");
        }
    }
}
