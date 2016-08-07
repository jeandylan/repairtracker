<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\CustomerAddress;

class CustomerAddressController extends Controller
{
    public function store(Request $request)
    {
        $rules = array(
            'type'       => 'required',
            'address'      => 'required',
            'customer_id' =>'required'
        );

        $validationMessages = [
            'type.required' => 'address Type not given',
            'address.required' => 'address details not given',
            'customer_id.required' => 'customer_id is needed'
        ];

        $validator = Validator::make(Input::all(), $rules, $validationMessages);

        if ($validator->passes()) {
            $customerAddress= new CustomerAddress(Input::all());
            $customerAddress->save();
            return response()->json(["successful"=>true, 'message' => 'Address Created Sucessful']);
        }
        else{
            return response()->json(["successful"=>false, 'message' =>implode(" .\n ",$validator->errors()->all())]);

        }


    }


    public function update(Request $request, $id)
    {
        $address=CustomerAddress::find($id);
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
        $address = CustomerAddress::find($id); //get Customer with id X
        if($address!=null) {
            $address->delete($id); //delete the Customer add
            return array("successful" => true, "message" => "address was deleted");
        }
        else{
            return array("successful" => false , "message" => "address was not deleted Unknown/unsaved ");
        }
    }
}
