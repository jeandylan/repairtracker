<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Stock;

class CrudStockTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
*/
    public function testCreateStock(){
        $this->json("POST", 'api/stock',['product_name'=>"GSM antenna",'selling_price'=>200.45,'reorder_level'=>3,'barcode'=>'123457890'])
            ->seeJson(['successful'=>true]);

    }
    public function testReadStock(){
        $stockId=Stock::all()->last()->id; //get the Id Of the last Stock in Db TO do test
        $this->json("GET",'api/stock/'.$stockId)
            ->seeJson(['id'=>$stockId]);
    }

    public function testUpdateStock(){ //Updating selling_price
        $stockId=Stock::all()->last()->id; //get the Id Of the last Stock in Db TO do test
        $this->json("PUT", 'api/stock/'.$stockId,['selling_price'=>200.45])
            ->seeJson(['successful'=>true]);
        $this->json("GET",'api/stock/'.$stockId)
            ->seeJson(['selling_price'=>200.45]);

    }

    public function testDeleteStock(){
        $stockId=Stock::all()->last()->id; //get the Id Of the last Stock in Db TO do test
        $this->json("DELETE", 'api/stock/'.$stockId)
            ->seeJson(['successful'=>true]);
    }

}
