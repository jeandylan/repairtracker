<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\SupplierTelephone;

class SupplierTelephoneController extends Controller
{
    public function store(){
        $rules = array(
            'type'       => 'required',
            'telephone_number'      => 'required',
            'supplier_id' =>'required'
        );
        $validationMessages = [
            'type.required' => 'telephone Type not given',
            'telephone_number.required' => 'telephone number not given',
            'supplier_id.required' => 'supplier_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $supplierTelephone= new SupplierTelephone(Input::all());
            $supplierTelephone->save();
            return response()->json(["successful"=>true, 'message' => 'telephone Created Successful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }
    }

    public function update(Request $request, $id)
    {
        $telephone=SupplierTelephone::find($id);

        if ($telephone != null) {
            $telephone->update(Input::all());
            return response()->json(["successful" => true, 'message' => 'telephone Update Successful']);
        }
        else{
            return array("successful"=>false, "message"=>"updating  unknown/unsaved Telephone");
        }
    }
    public function destroy($id)
    {
        $telephone = SupplierTelephone::find($id); //get Customer with id X
        if ($telephone != null) {
            $telephone->delete($id); //delete the email
            return array("successful"=>true, "message"=>"email was deleted");
        }
        else{
            return array("successful"=>false, "message"=>"deleting unknown/unsaved Telephone");
        }
    }

}
