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


            $ticket = new Ticket();
            $ticket->customer_id = $customerId;
            $textField=input::get('text_field');
            $ticket->make = $textField[0]['make'];
            $ticket->model = $textField[0]['model'];
            $ticket->problem_type = $textField[0]['problem_type'];
            $ticket->problem_definition =$textField[0]['problem_definition'];
            $ticket->customer()->associate($customerId);

            $ticket->save(); //Need To save Ticket Before It can Be assigned To employee Because of manyToMany rel
            //check if technician Id Is provided  uses this Id to assign Technician
            if(input::get('technician_id')) $ticket->employee()->attach(input::get('technician_id'));

            $lastTicketId= $ticket->id; //get the new Ticket Id

            if(input::get('custom_text_fields_data')){
                $cutomTextFieldsData=input::get('custom_text_fields_data');
                foreach ( $cutomTextFieldsData as $customText){
                   $customTextFieldData = new CustomTextFieldData();
                    $customTextFieldData->custom_text_field_id=$customText['custom_text_field_id'];
                    $customTextFieldData->entity_id=$lastTicketId;
                  $customTextFieldData->field_data=$customText['field_data'];
                    $customTextFieldData->save();
                }
            }

            if(input::get('isEmail')){
                $mail=new GmailMailler();
                $mail->sentMail("ergergregrrvbrtfv rever");

                return "yyyyyy";


            }
            return  array("successful"=>true, "message"=>"ticket  created","ticketId"=>$lastTicketId);
        }
        else{
            return array("successful"=>false,"message"=>"cannot store Ticket, user Does not exist");
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
        $ticket->employee();
        return $ticket;
    }

    public function setTechnician($ticketId){
        $ticket=Ticket::find($ticketId);
        if(!$ticket) {
            return  array("successful"=>false, "message"=>"ticket in another shop /or deleted from db");
        }
        $technician = Employee::find(input::get('employee_id'));
        $ticket->employee()->attach($technician->id,Input::all());

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
