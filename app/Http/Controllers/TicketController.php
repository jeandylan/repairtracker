<?php

namespace App\Http\Controllers;

use App\CustomTextFieldData;

use App\Employee;
use App\TicketComment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Common\Utility;
use App\Http\Requests;
use App\CustomTextField;
use CustomTextFieldu;
use App\Ticket;
use App\Customer; //model should be used to check if customer Id exist

use App\Mylibs\GmailMailler;


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

            $ticketData=Input::all();
            $ticketData['customer_id']=$customerId; //add the Customer Id To to ticket Data
            $ticket=new Ticket($ticketData);
            //$ticket->estimated_completion_date="2016-01-03";
            $ticket->save();
            //Now Sent Email
            $emailOutput="";

            $customerDetails=Customer::find($customerId);
            foreach ($customerDetails->email()->get() as $customerEmail ){
                $ticketEmail=new GmailMailler();
              $emailOutput .=  $ticketEmail->SentTicketCreation($customerEmail->email,$customerDetails->first_name,"ticket Creation",
                  "ferfr","we Have a ticket for you ");

            }



            return  array("successful"=>true, "message"=>"ticket  created, $emailOutput","ticketId"=>$ticket->id); //return the new Ticket ID
        }
        else{
            return response()->json(['error' => 'Error msg'], 404); // Status code here
        }
    }

    public function getComments($ticketId){
        $comments=TicketComment::where('ticket_id','=',$ticketId)->get(); //all comments for ticket
        $output=[];
        foreach ($comments as $comment){
            if($comment['employee_id']!= "") {
                $ticketAuthor=Employee::find(1);
                $comment["author"]=array("first_name"=>$ticketAuthor->first_name,"last_name"=>$ticketAuthor->last_name,"id"=>$ticketAuthor->id);
                array_push($output,$comment);
            }
            else{
                array_push($output,$comment);
            }
        }
      return $output;


    }



    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->update(Input::all());
        return  array("successful"=>true, "message"=>"ticket updated");
    }

    public function getTechnician(Request $request,$ticketId){
        $ticket=Ticket::find($ticketId);
       $employee= $ticket->employee();
        return $employee;
    }

    public function setTechnician($ticketId){
        $ticket=Ticket::find($ticketId);
        if(!$ticket) {
            return  array("successful"=>false, "message"=>"ticket in another shop /or deleted from db");
        }
        $technician = Employee::find(input::get('employee_id'));
        $ticket->employee()->attach($technician->id,Input::all());
        return  array("successful"=>true, "message"=>"Technican Job updated");

    }

    public function destroy($id)
    {
        Ticket::find($id)->delete();
        return  array("successful"=>true, "message"=>"ticket deleted");

    }
    public function getCustomFields()
    {
        return  CustomTextField::where('form_name', '=', 'ticket')->get();



    }
    public function getCustomFieldsData($ticketId){
        $tic=new Ticket();
        return $tic->customTextFieldDetails($ticketId);
    }

    public function customerComment(Request $request){
        return $request;

    }
}
