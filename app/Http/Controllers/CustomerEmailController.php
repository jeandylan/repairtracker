<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\CustomerEmail;


class CustomerEmailController extends Controller
{
    public function store(){
        $rules = array(
            'type'       => 'required',
            'email'      => 'required',
            'customer_id' =>'required'
        );
        $validationMessages = [
            'type.required' => 'email Type not given',
            'email.required' => 'email details not given',
            'customer_id.required' => 'customer_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $customerEmail= new CustomerEmail(Input::all());
            $customerEmail->save();
            return response()->json(["successful"=>true, 'message' => 'email Created Sucessful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }
    }

    public function update(Request $request, $id)
    {
        $email=CustomerEmail::find($id);
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
        $email = CustomerEmail::find($id); //get Customer with id X
        if ($email != null) {
            $email->delete($id); //delete the email
            return array("successful"=>true, "message"=>"email was deleted");
        }
        else{
            return array("successful"=>false, "message"=>"deleting unknown Email");
        }




    }

}
