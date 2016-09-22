<?php

namespace App\Http\Controllers;

use App\Estimation;
use App\InvoiceLabour;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\EstimationLabour;
use App\Ticket;
use App\Customer;
use App\Stock;
use App\Invoice;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    public function store($customerId)
    {
        if(Customer::where('id','=',$customerId)->exists()) { //check if Customer ID in dB so as not to break foreignkey constrain


            $ticket = new Ticket();
            $ticket->customer_id = $customerId;
            $ticket->make = input::get('make');
            $ticket->model = input::get('model');
            $ticket->problem_definition = input::get('problem_type');
            $ticket->problem_definition = input::get('problem_definition');
            $ticket->save();
            $lastTicketId= $ticket->id;
            return $lastTicketId;
        }
        return "err";


    }

    public function get($ticketId){
        $ticket=Ticket::find($ticketId);
       if(!$invoice=$ticket->invoice()->first()){
           $invoice=new Invoice();
           $ticket->invoice()->save($invoice);
       }
        $invoice=$ticket->invoice()->first();
       //get Only Stock Details
        $invoiceLabour=$invoice->labour()->get();
        $invoiceStock=$ticket->stockOnly()->get();
        return array('stocks'=>$invoiceStock,'labours'=>$invoiceLabour);


    }

    public function createLabour($ticketId,Request $request){
        $ticket=Ticket::find($ticketId);
        if($invoice=$ticket->invoice()->first()){
            $invoice->labour()->create(['name'=>$request->name,'cost'=>$request->cost]);
            return  array("successful"=>true, "message"=>"estimation updated");
        }
        else{ //If no invoice create One,then save Labour to it
            $invoice=new Invoice();
            $ticket->invoice()->save($invoice);
            $invoice=$ticket->invoice()->first();
            $invoice->labour()->create(['name'=>$request->name,'cost'=>$request->cost]);


        }

    }

    public  function updateLabour($labourId,Request $request){
        $labour=InvoiceLabour::find($labourId);
        $labour->update(['name'=>$request->name,'cost'=>$request->cost]);
        return  array("successful"=>true, "message"=>"estimation updated");
    }
}
