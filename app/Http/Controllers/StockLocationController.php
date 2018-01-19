<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\StockLocationLevel;
use App\Http\Requests;
use Illuminate\Support\Collection;

class StockLocationController extends Controller
{
    public function getAll(){

        $stocksLocation=StockLocationLevel::all();
        $output=[];
        foreach ($stocksLocation as $stockLocation){
            $stockDetails= $stockLocation->stock()->get()->first(); //get stock detail of location levl
            $stockDetails->setAttribute('current_level',$stockLocation->current_level); // add lvl of stock for location with stock detaisl
            $stockDetails->setAttribute('stock_location_level_id',$stockLocation->id);
            $stockDetails->setAttribute('shop_location',$stockLocation->shop_location);
            array_push($output,$stockDetails);
        }
        return $output;

    }


    public function get($stockLocationLevelId){
        $stockLocationLevel=StockLocationLevel::find($stockLocationLevelId);
        $stockDetails=$stockLocationLevel->stock()->get()->first(); //Get stock details assoc. with the Stock location lvl
        $stockDetails->setAttribute('current_level',$stockLocationLevel->current_level); //Add StockLevl detail of location With the StockDetails
        $stockDetails->setAttribute('stock_location_level_id',$stockLocationLevel->id);
        $stockDetails->setAttribute('shop_location',$stockLocationLevel->shop_location);
        $stockDetails->setAttribute('stock_id',$stockLocationLevel->stock_id);
        return $stockDetails;
    }

    public function update($stockLocationLevelId,Request $request){
        $stockLocationLevel=StockLocationLevel::find($stockLocationLevelId);
        $stockLocationLevel->current_level=$request->current_level;
        $stockLocationLevel->save();
    }

    public function search()
    {
        $product_name = Input::get('product_name');
        if($product_name){
            $stocks=Stock::where("product_name", "LIKE", "%$product_name%")->get();
            foreach ($stocks as $stock){
                $locationLevel=$stock->stockLocationLevel()->get()->first();
                if($locationLevel) //some may not have Location level ,because we forget to put it in db
                    $stock->setAttribute('current_level',$locationLevel->current_level);

            }
            return $stocks;
        }
        return array();

    }


}
