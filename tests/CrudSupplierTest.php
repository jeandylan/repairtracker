<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Supplier;

class CrudSupplierTest extends TestCase
{
    public function testCreateSupplier(){
        $this->json("POST", 'api/supplier',['first_name'=>"Johnny",'last_name'=>'Depp','company'=>"le Jeu Du Johnny Depp",'mobile_tel'=>'455664','email'=>'johnny@depp.com'])
            ->seeJson(['successful'=>true]);

    }
    public function testReadStock(){
        $supplierId=Supplier::all()->last()->id; //get the Id Of the last Supplier in Db TO do test
        $this->json("GET",'api/supplier/'.$supplierId)
            ->seeJson(['id'=>$supplierId]);
    }

    public function testUpdateStock(){ //Updating selling_price
        $supplierId=Supplier::all()->last()->id; //get the Id Of the last Supplier in Db TO do test
        $this->json("PUT", 'api/supplier/'.$supplierId,['company'=>"JohnnyHenryDepp"])
            ->seeJson(['successful'=>true]);

        $this->json("GET",'api/supplier/'.$supplierId)
            ->seeJson(['company'=>"JohnnyHenryDepp"]);

    }

    public function testDeleteStock(){
        $supplierId=Supplier::all()->last()->id; //get the Id Of the last Supplier in Db TO do test
        $this->json("DELETE", 'api/supplier/'.$supplierId)
            ->seeJson(['successful'=>true]);
    }
}
