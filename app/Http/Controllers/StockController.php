<?php

namespace App\Http\Controllers;
use App\StockLocationLevel;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Stock;
use App\SaasCompanyLocation;
use App\StockLocationCreator; //use this to create stock in every company will not use the belong to ,which other wise will
//apply hotname automatically yto tbl



class StockController extends Controller
{
    public function getAll()
    {
        return Stock::all();


    }

    /*
     * store A New Stock
     * @param Takes Input from Ajax Json
     * @return Successful (0 or 1)
     */

    public function store(Request $request)
    {
        $rules = array(
            'product_name' => 'required',
            'selling_price' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules); //validate input according to rule above
        $stock = new Stock(Input::all());
        //As data was  send with Dataname that correspond to that in Db ,no need to precise what input goes in what table field(row),(laravel Figure it out)
        $stock->save();
        $companyNameSavingStock=explode(".",Request::server('HTTP_HOST'))[1];
        $this->createStockForCompanyLocation($companyNameSavingStock,$stock->id);
        return array("successful" => true, "message" => "stock was created");
    }

    /*
     * create a stock level for location abc  with a stock id of rtry

     */

    public function createStockForCompanyLocation($companyNameSavingStock,$stockId){
         $companyLocations=app('App\Http\Controllers\SaasAdmin\CompanyController')->getActiveCompanyLocationsByName($companyNameSavingStock);
        foreach ($companyLocations as $companyLocation){
             $locationName=explode(".",$companyLocation['location_hostname'])[0];
            if($locationName!="admin"){//do not create for location Admin
                $stockLocation=new StockLocationCreator(); //use creator intead of StockLocation ,REASON ON THIS FILE HEADER
                $stockLocation->stock_id=$stockId;
                $stockLocation->shop_location=$companyLocation['location_hostname'];
                $stockLocation->current_level=0;
                $stockLocation->save();
            }

        }


    }

    public function get($id)
    {

        try {
            return Stock::find($id);

        } catch (\Illuminate\Database\QueryException $e) {
            return "error";
        }
    }


    public function update($id)
    {
        $rules = array(
            'product_name' => 'required',
            'selling_price' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        $stock = Stock::find($id);
        $stock->update(Input::all());
        return array("successful" => true, "message" => "Stock item was updated");

    }


    public function destroy($id)
    {
        //Delete A Stock with id X
        try {
            $stock = Stock::find($id); //get Customer with id X
            $stock->delete($id); //delete the Customer
            return array("successful" => true, "message" => "Stock item was deleted");
        } catch (\Illuminate\Database\QueryException $ex) {
            return array("successful" => false, "message" => "An error Db");
        }

    }

    public function search()
    {
        $product_name = Input::get('product_name');
        if($product_name){
            $stocks=Stock::where("product_name", "LIKE", "%$product_name%")->get();
            return $stocks;
        }
        return array();

    }
    //stock lvl
    public function level($stockId){
        return StockLocationLevel::where("stock_id","=",$stockId)->get();
    }

    function stockLocationReduce($stockId){
        $qty_reduce=Input::get('reduce_by'); //qty to reduce stock lvl
       $stockLocationLevel=StockLocationLevel::where("stock_id","=",$stockId)->first();
        if($qty_reduce <= $stockLocationLevel->current_level && ctype_digit($qty_reduce)) { //Stock is enought to be
            // reduced ,and qty to be reduce is provided(in int)
            $stockLocationLevel->current_level-=Input::get('reduce_by');
            $stockLocationLevel->save();
            return array("successful" => true, "message" => "Stock item was updated");
        }
        return response()->json(['error' => 'Not enoght Stock '], 404);
    }

    function getSuppliers($stockId){
        if($stock=Stock::find($stockId)){
            return $stock->suppliers()->get();
        }
    }


}
