<?php namespace Phpleaks\Http\Requests;

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Common\Utility;
use \Exception;
use App\Http\Requests;
use App\Customer;
use App\CustomerAddress;
use App\CustomerTelephone;
use App\CustomerEmail;

//use Mockery\CountValidator\Exception;

class CustomerController extends Controller
{
    /**
     * !!!!!!!!!!!!very import do import the model first!!!!!!!!!!!!!!!!
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return Customer::all();


    }
    
    /*
     * store A New Customer
     * @param Takes Input from Ajax Json
     * @return Successful (0 or 1)
     */

    public function store(Request $request)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data

        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required',
        );
        
        $validator = Validator::make(Input::all(), $rules); //validate input according to rule above

        $customer = new Customer(Input::except('telephones','emails','addresses')); //As data was  send with Dataname that is the same as declared in db (filed first name was send as first_name ,same as in db),
        // no need to precise what input goes in what table field(row),(laravel knows where to put the data if input Name declared in json data is the same as dbName)
        $customer->save();

        $addresses=Input::get('addresses');
        foreach ($addresses as $address) $customer->address()->create($address);

        $telephones=Input::get('telephones'); //get Telephone Number Array
        foreach ($telephones as $telephone) $customer->telephone()->create($telephone);

        $emails=Input::get('emails');
        foreach ($emails as $email) $customer->email()->create($email);

       return  array("successful"=>true, "message"=>"customer was created");
    }

    /*
     * get Customer Detail with id X
     * **return Details of Customer With id X
     */


    public function get($id)
    {

        try {

            $customer= Customer::find($id);
            return ($customer != null) ? response()->json(['successful'=>true,'personal' => $customer, 'addresses' => $customer->address()->get(),'telephones'=>$customer->telephone()->get(),'emails'=>$customer->email()->get()]):
            response()->json(['successful'=>false,'message'=>'cannot find customer']);


        }
        catch (\Illuminate\Database\QueryException $e){
            return "error";
        }
    }




    public function update($id)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data
        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required',
            'email' => 'email',
        );

        $validator = Validator::make(Input::all(), $rules);
        $customer = Customer::find($id);
        $customer->update(Input::all());
        return  array("successful"=>true, "message"=>"customer was updated");

    }


    public function destroy($id)
    {
        //Delete A customer with id X
        try {
           $customer = Customer::find($id); //get Customer with id X
            $customer->delete($id); //delete the Customer
            return  array("successful"=>true, "message"=>"customer was deleted");
        }

        catch (\Illuminate\Database\QueryException $ex){
            return  array("successful"=>false, "message"=>"An error Db");
        }


    }





}
