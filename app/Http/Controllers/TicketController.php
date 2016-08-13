<?php

namespace App\Http\Controllers;

use App\TxtFieldData;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Common\Utility;
use App\Http\Requests;
use App\TxtField;
use App\Ticket;
use App\Customer; //model should be used to check if customer Id exist


class TicketController extends Controller
{


    public function getAll(){
        return Ticket::all();
    }

    public function get($id){
        $ticket= Ticket::find($id);
        return response()->json(['successful'=>true,'info' => $ticket, 'customer' => $ticket->customer()->get(),'stocks'=>$ticket->stock()->get(),'employees'=>$ticket->employee()->get()]);
    }


    public function store($customerId)
    {
        if(Customer::where('id','=',$customerId)->exists()) { //check if Customer ID in dB so as not to break foreignkey constrain


            Utility::stripXSS();//prevent xss , should be called before server side validation so as validation is done on safe data
            $ticket = new Ticket();
            $ticket->customer_id = $customerId;
            $ticket->make = input::get('make');
            $ticket->model = input::get('model');
            $ticket->problem_type = input::get('problem_type');
            $ticket->problem_definition = input::get('problem_definition');
            $ticket->save();
            $lastTicketId= $ticket->id;
            return  array("successful"=>true, "message"=>"ticket  created","ticketId"=>$lastTicketId);
        }
        return array("successful"=>false,"message"=>"cannot store Ticket, user Does not exist");


    }



    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->update(Input::all());
        return  array("successful"=>true, "message"=>"ticket updated");
    }


    public function destroy($id)
    {
        Ticket::find($id)->delete();
        return  array("successful"=>true, "message"=>"ticket deleted");

    }
    public function getAdditionalField()
    {
        return  TxtField::where('form_name', '=', 'App\Ticket')->get();

    }
    public function fields($ticketId){
        $tic=new Ticket();
        return $tic->fieldDetails($ticketId);
    }
}
