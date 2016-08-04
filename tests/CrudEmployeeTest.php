<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Employee;

class CrudEmployeeTest extends TestCase
{
    public function testCreateEmployee(){
        $this->json("POST", 'api/employee',['first_name'=>"Paul",'last_name'=>'overRated Pogba','date_of_birth'=>'2000-01-08','mobile_tel'=>'32636974287','role'=>'technician'])
            ->seeJson(['successful'=>true]);

    }
    public function testReadEmployee(){
        $employeeId=Employee::all()->last()->id; //get the Id Of the last Stock in Db TO do test
        $this->json("GET",'api/employee/'.$employeeId)
            ->seeJson(['id'=>$employeeId]);
    }

    public function testUpdateEmployee(){ //Updating selling_price
        $employeeId=Employee::all()->last()->id; //get the Id Of the last Stock in Db TO do test
        $this->json("PUT", 'api/employee/'.$employeeId,['first_name'=>"bruce"])
            ->seeJson(['successful'=>true]);

        $this->json("GET",'api/employee/'.$employeeId)
            ->seeJson(['first_name'=>"bruce"]);

    }

    public function testDeleteStock(){
        $employeeId=Employee::all()->last()->id; //get the Id Of the last Stock in Db TO do test
        $this->json("DELETE", 'api/employee/'.$employeeId)
            ->seeJson(['successful'=>true]);
    }
}
