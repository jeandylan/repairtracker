<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Common\Utility;
use App\Http\Requests;
use App\Ticket;
use App\Customer; //model should be used to check if customer Id exist


class TicketController extends Controller
{


    public function getAll(){
        return Ticket::all();
    }

    public function get($id){
        return Ticket::find($id);
    }


    public function store($customerId)
    {
        if(Customer::where('id','=',$customerId)->exists()) { //check if Customer ID in dB so as not to break foreignkey constrain


            Utility::stripXSS();//prevent xss , should be called before server side validation so as validation is done on safe data
            $ticket = new Ticket();
            $ticket->customer_id = $customerId;
            $ticket->make = input::get('make');
            $ticket->model = input::get('model');
            $ticket->problem_definition = input::get('problem_type');
            $ticket->problem_definition = input::get('problem_definition');
            $ticket->save();
            $lastTicketId= $ticket->id;
            return  array("successful"=>true, "message"=>"ticket  created","ticketId"=>$lastTicketId);
        }
        return array("successful"=>false,"message"=>"cannot store Ticket, user Does not exist");


    }



    public function update(Request $request, $id)
    {
        Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data
        $ticket = Ticket::find($id);
        $ticket->update(input::get());
        return  array("successful"=>true, "message"=>"ticket updated");
    }


    public function destroy($id)
    {
        Ticket::find($id)->delete();
        return  array("successful"=>true, "message"=>"ticket deleted");

    }
}
