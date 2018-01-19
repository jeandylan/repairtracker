<?php

namespace App\Http\Controllers;


use App\Stock;
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
        try {

            $supplier= Supplier::find($id);
            return ($supplier != null) ? response()->json(['successful'=>true,'personal' => $supplier, 'addresses' => $supplier->address()->get(),'telephones'=>$supplier->telephone()->get(),'emails'=>$supplier->email()->get()]):
                response()->json(['successful'=>false,'message'=>'cannot find supplier']);


        }
        catch (\Illuminate\Database\QueryException $e){
            return "error";
        }

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

        $addresses=Input::get('addresses');
        foreach ($addresses as $address) $supplier->address()->create($address);

        $telephones=Input::get('telephones'); //get Telephone Number Array
        foreach ($telephones as $telephone) $supplier->telephone()->create($telephone);

        $emails=Input::get('emails');
        foreach ($emails as $email) $supplier->email()->create($email);

        return  array("successful"=>true, "message"=>"Supplier was created");
    }



    public function update(Request $request, $id)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data
        $supplier = Supplier::find($id);
        $supplier->update(Input::get());
        return  array("successful"=>true, "message"=>"supplier updated");
    }


    public function destroy($id)
    {
        try {
            Supplier::find($id)->delete();
            return array("successful" => true, "message" => "supplier deleted");
        }
        catch (\Exception $e){
            return array("successful" => false, "message" => "supplier cannot be deleted");
        }

    }


    public function suppliedStock($supplierId){
        if($supplier=Supplier::find($supplierId)){
            return $supplier->stocks()->get();
        }
    }

    public  function  removeSuppliedStock(Request $request,$supplierId){
        if(($supplier=Supplier::find($supplierId)) && ($stock=Stock::find($request->stock_id))){
            $supplier->stocks()->detach($stock->id);
            return array("successful" => true, "message" => "supplid stock Deleted");
        }

    }

    public function addSuppliedStock(Request $request,$supplierId){
        if(($supplier=Supplier::find($supplierId)) && ($stock=Stock::find($request->stock_id))){
            $supplier->stocks()->attach($stock->id);
            return array("successful" => true, "message" => "supplier now suppliers this Stock ");
        }
    }
}
