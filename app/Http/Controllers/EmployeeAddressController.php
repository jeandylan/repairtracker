<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\EmployeeAddress;
class EmployeeAddressController extends Controller
{

    public function store(Request $request)
    {
        $rules = array(
            'type'       => 'required',
            'address'      => 'required',
            'employee_id' =>'required'
        );

        $validationMessages = [
            'type.required' => 'address Type not given',
            'address.required' => 'address details not given',
             'employee_id.required' => 'employee_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $employeeAddress= new EmployeeAddress(Input::all());
            $employeeAddress->save();
            return response()->json(["successful"=>true, 'message' => 'Address Created Sucessful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }


    }


    public function update(Request $request, $id)
    {
           $address=EmployeeAddress::find($id);
               if($address!= null){
                   $address->update(Input::all());
                   return response()->json(["successful"=>true, 'message' => 'address Update Sucessful']);
               }
        else{
            return response()->json(["successful"=>false, 'message' => 'address Update failed unknown /unsaved add']);
        }


    }


    public function destroy($id)
    {
        $address = EmployeeAddress::find($id); //get Customer with id X
        if($address!=null) {
            $address->delete($id); //delete the Customer
            return array("successful" => true, "message" => "address was deleted");
        }
        else{
            return array("successful" => false , "message" => "address was not deleted Unknown/unsaved ");
        }
    }
}
