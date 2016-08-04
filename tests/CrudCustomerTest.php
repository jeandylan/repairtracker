<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;

class CrudCustomerTest extends TestCase
{



    public function testCreateCustomer(){
        $this->json('POST', 'api/customer', ['first_name' => 'John','last_name'=>'doe','email'=>'johnDoe.yahoo.com'])
            ->seeJson(['successful' => true]);
    }

    public function testReadCustomer(){
        $customerId=Customer::all()->last()->id; //get the Id Of customer Created By Function createCustomer
        $this->json('GET','api/customer/'.$customerId)
            ->seeJson(['id' => $customerId]);
    }

    public function testUpdateCustomerLastName(){
        $customerId=Customer::all()->last()->id; //get the Id Of customer Created By Function createCustomer
        $this->json('PUT', 'api/customer/'.$customerId, ['first_name' => 'Johnny','last_name'=>'nekfeu','email'=>'johnDoe.yahoo.com'])
            ->seeJson(['successful' => true]);

        $this->get('api/customer/'.$customerId)
            ->seeJson(['last_name' => 'nekfeu']);
    }

    public function testDeleteCustomer(){
        $customerId=Customer::all()->last()->id; //get the Id Of customer Created By Function createCustomer
        $this->json('DELETE', 'api/customer/'.$customerId)
            ->seeJson(['successful' => true]);
    }
}
