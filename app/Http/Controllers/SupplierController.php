<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Supplier;
use App\Http\Requests;
use App\Common\Utility;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\SupplierAddress;
use App\SupplierEmail;
use App\SupplierTelephone;

class SupplierController extends Controller
{
    public function getAll(){
        return Supplier::all();
    }

    public function get($id){
        return Supplier::find($id);
    }


    public function store()
    {

        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data

        $rules = array(
            'product_name'       => 'required',
            'selling_price'      => 'required',
        );
        $validator = Validator::make(Input::except('telephones','emails','addresses'), $rules); //validate input according to rule above
        $supplier = new Supplier(Input::except('telephones','emails','addresses'));
        //As data was  send with Dataname that correspond to that in Db ,no need to precise what input goes in what table field(row),(laravel Figure it out)
        $supplier ->save();

        $supplierId=$supplier->id; //Id Of supplier created

        $telephones=Input::get('telephones'); //get Telephone Number Array

        foreach ($telephones as $telephone) {
            $supplierTelephone=new supplierTelephone;
            $supplierTelephone->supplier_id=$supplierId;
            $supplierTelephone->type=$telephone['type'];
            $supplierTelephone->telephone_number=$telephone['telephone_number'];
            $supplierTelephone->save();
        }

        $addresses=Input::get('addresses');

        foreach ($addresses as $address){
            $supplierAddress=new supplierAddress;
            $supplierAddress->supplier_id=$supplierId;
            $supplierAddress->type=$address['type'];
            $supplierAddress->address=$address['address'];
            $supplierAddress->save();

        }

        $emails=Input::get('emails');

        foreach ($emails as $email){
            $supplierEmail=new supplierEmail;
            $supplierEmail->supplier_id=$supplierId;
            $supplierEmail->type=$email['type'];
            $supplierEmail->email=$email['email'];
            $supplierEmail->save();

        }
        return  array("successful"=>true, "message"=>"supplier was created");


    }



    public function update(Request $request, $id)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data
        $supplier = Supplier::find($id);
        $supplier->update(Input::get());
        return  array("successful"=>true, "message"=>"ticket updated");
    }


    public function destroy($id)
    {
        try {
            Supplier::find($id)->delete();
            return array("successful" => true, "message" => "ticket deleted");
        }
        catch (\Exception $e){
            return array("successful" => false, "message" => "ticket cannot be deleted");
        }

    }
}
