<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\SupplierAddress;

class SupplierAddressController extends Controller
{
    public function store(Request $request)
    {
        $rules = array(
            'type'       => 'required',
            'address'      => 'required',
            'supplier_id' =>'required'
        );

        $validationMessages = [
            'type.required' => 'address Type not given',
            'address.required' => 'address details not given',
            'supplier_id.required' => 'supplier_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $supplierAddress= new SupplierAddress(Input::all());
            $supplierAddress->save();
            return response()->json(["successful"=>true, 'message' => 'Address Created Successful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }


    }


    public function update(Request $request, $id)
    {
        $address=SupplierAddress::find($id);
        if($address!= null){
            $address->update(Input::all());
            return response()->json(["successful"=>true, 'message' => 'address Update Successful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' => 'address Update failed unknown /unsaved add']);
        }


    }


    public function destroy($id)
    {
        $address = SupplierAddress::find($id); //get Supplier with id X
        if($address!=null) {
            $address->delete($id); //delete the Supplier add
            return array("successful" => true, "message" => "address was deleted");
        }
        else{
            return array("successful" => false , "message" => "address was not deleted Unknown/unsaved ");
        }
    }
}
