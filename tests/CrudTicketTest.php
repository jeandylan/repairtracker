<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Ticket;
use App\Customer;
class CrudTicketTest extends TestCase
{
    /*
    * test read,create,update,delete Ticket
    * */
/*
 * test Normal
 */
    public function  testCreateTicket(){
        $customerId=Customer::all()->last()->id; //get the Id Of the last Customer in Db TO do test
        $this->json('POST', 'api/ticket/'.$customerId,['make' => 'Samsung','model'=>'s4','problem_type'=>'no wifi', 'problem_definition'=>'customer cannot turn on wifi if device..'] )
            ->seeJson(['successful' => true]);
    }

    public function  testReadTicket(){
        $ticketId=Ticket::all()->last()->id; //get the Id Of Ticket Created By Function createTicket i.e last ticket created
        $this->json('GET', 'api/ticket/'.$ticketId)
            ->seeJson(['id' => $ticketId]);
    }

    public function  updateTicketMake(){
        $ticketId=Ticket::all()->last()->id; //get the Id Of Ticket Created By Function createTicket i.e last ticket created

        $this->json('PUT', 'api/ticket/'.$ticketId,['make' => "LG"])  //change the Ticket make to LG
        ->seeJson(['successful' => true]);

        $this->json('GET', 'api/ticket/'.$ticketId) //read the updated Ticket from Db,to test if Make Change
        ->seeJson(['make' => "LG"]); //see if JSON contain updated Make,should now be LG

    }


    public function  deleteTicket($ticketId){
        $ticketId=Ticket::all()->last()->id; //get the Id Of Ticket Created By Function createTicket i.e last ticket created
        $this->json('DELETE', 'api/ticket/'.$ticketId)
            ->seeJson(['successful' => true]);
    }

    /*
     * Test Abnormal
     */
}
