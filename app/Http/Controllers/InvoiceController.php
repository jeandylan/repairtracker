<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Ticket;
use App\Customer;
use App\Stock;
use App\Invoice;

class InvoiceController extends Controller
{
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
            return $lastTicketId;
        }
        return "err";


    }
}
