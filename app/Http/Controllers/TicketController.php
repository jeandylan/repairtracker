<?php

namespace App\Http\Controllers;

use App\AllEmployee;
use App\CustomTextFieldData;
use App\Mylibs\JWTAut;
use App\Mylibs\TwilloSms;
use Illuminate\Support\Facades\DB;
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
use App\Stock;
use App\EmployeeTicket;
use App\Ticket;
use App\Customer; //model should be used to check if customer Id exist

use App\Mylibs\GmailMailler;
use League\Flysystem\Exception;


class TicketController extends Controller
{


    public function getAll(){
        return Ticket::all();
    }

    public function get($id){
        $ticket= Ticket::find($id);
        return $ticket;
        //return response()->json(['successful'=>true,'info' => $ticket, 'customer' => $ticket->customer()->get(),'stocks'=>$ticket->stock()->get(),'employees'=>$ticket->employee()->get()]);
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
             /*   $ticketEmail=new GmailMailler();
              $emailOutput .=  $ticketEmail->SentTicketCreation($customerEmail->email,$customerDetails->first_name,"ticket Creation",
                  "ferfr","we Have a ticket for you ");
             */
            }
            return  array("successful"=>true, "message"=>"ticket  created, $emailOutput","ticketId"=>$ticket->id); //return the new Ticket ID
        }
        else{
            return response()->json(['error' => 'Error msg'], 404); // Status code here
        }
    }



    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->update(Input::all());
        return  array("successful"=>true, "message"=>"ticket updated");
    }


    public function getStock($ticketId){
        $ticket=Ticket::find($ticketId);
        $stocksTicket= $ticket->stock()->get();
        $output=[];
        foreach ($stocksTicket as $stockTicket){ //iTerate truw Stock stock associated with Ticket (many Stock)
            $stock=Stock::find($stockTicket->stock_id); //find the Stock Details Of the associated stock Used
           array_push($output,['stock'=>$stock,'stock_ticket'=>['id'=>$stockTicket->id,'qty_out'=>$stockTicket->qty_out,]]);
        }
        return $output;


    }

    public function destroy($id)
    {
        Ticket::find($id)->delete();
        return  array("successful"=>true, "message"=>"ticket deleted");

    }
    public function getCustomFieldUpdating($ticketId){
        $output=[];
        $customFields=CustomTextField::where('form_name','=','ticket')->get();
        foreach ($customFields as $customField){
            if($customFieldData=$customField->fieldData()->where('entity_id','=',$ticketId)->get()){ //if ticket already Have Data for custom Property
                array_push($output,array("data"=>$customFieldData->first(),"properties"=>$customField));
            }
            else{
                array_push($output,["properties"=>$customField]);
            }


        }
        return $output;

    }


    public function getCustomerEmail($ticketId){
        $ticket=Ticket::find($ticketId);
       return  $ticket->customer()->first()->email()->get();


    }

    /**most of these are not used i think*/
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
