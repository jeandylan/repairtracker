<?php

namespace App\Http\Controllers;

use App\StockTicket;
use Illuminate\Http\Request;
use App\Stock;
use App\Ticket;
use App\StockLocationLevel;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class StockTicketController extends Controller
{
    public function get($ticketId){
        $ticket=Ticket::find($ticketId);
        if(!$ticket) return response()->json(['error' => "Ticket Not found :-or other reasons"], 404);
        $stocksTicket= $ticket->stock()->get();
        $output=[];
        foreach ($stocksTicket as $stockTicket){ //iTerate truw Stock stock associated with Ticket (many Stock)
            $stock=Stock::find($stockTicket->stock_id); //find the Stock Details Of the associated stock Used
            array_push($output,['stock'=>$stock,'stock_ticket'=>['id'=>$stockTicket->id,'qty_out'=>$stockTicket->qty_out,]]);
        }
        return $output;
    }

    function create($ticketId,Request $request){ //add A Stock to ticket
        $ticket=Ticket::find($ticketId);
        $stock=Stock::find($request->input('id'));
        $stockLocationLevel=StockLocationLevel::where("stock_id","=",$request->input('id'))->first();
        if(!$ticket || !$stock || !$stockLocationLevel) return response()->json(['error' => "Ticket Not found :-or other reasons"], 404);
        if($stockLocationLevel->current_level >= $request->input('qty_out')){
            $ticket->stock()->create(['qty_out'=>$request->input('qty_out'),'stock_id'=>$stock->id]);
            $stockLocationLevel->current_level-=$request->input('qty_out');
            $stockLocationLevel->save();
            return  array("successful"=>true, "message"=>"stock was deduce from inventory");
        }
        else{
            return response()->json(['error' => "Not enought Stock At Location"], 404);
        }
    }

    function update($ticketStockId,Request $request){
        $stockTicket=StockTicket::find($ticketStockId);
        if(!$stockTicket)return response()->json(['error' => "Ticket Stock Not found :-or other reasons"], 404);
        $stockLocationLevel=StockLocationLevel::where("stock_id","=",$stockTicket->stock_id)->first();
        if(!$stockLocationLevel)return response()->json(['error' => "Ticket Stock at location Not found :-or other reasons"], 404);
        /*if new qtyOut  is lower than original
        *qty out(means Employee will not be using item
        *from Inventory e.g wrongly enter stockOut item,item previously taken from stock no more Needed)
        */
        if($request->input('qty_out') > $stockTicket->qty_out){
            //Employee need more Stock,check Inventory lvl ,reduce Accordingly
            if($request->input('qty_out') > $stockLocationLevel->current_level) return response()->json(['error' => "not enought stock"], 404);
            $stockLocationLevel->current_level-=($request->input('qty_out')-$stockTicket->qty_out);
            $stockLocationLevel->save();
            $stockTicket->qty_out=$request->input('qty_out');
            $stockTicket->save();
            return  array("successful"=>true, "message"=>"stock item added to ticket , reduce in Inventory");
        }
        else{
            if($request->input('back_to_stock')==true){
                $stockLocationLevel->current_level+=$stockTicket->qty_out-($request->input('qty_out'));
                $stockTicket->qty_out=$request->input('qty_out');
                $stockTicket->save();
                return  array("successful"=>true, "message"=>"item  was added Back inventory");
            }
            else{
                if($request->input('qty_out') == $stockTicket->qty_out)return  array("successful"=>true, "message"=>"nothing Changed");
                $stockTicket->qty_out=$request->input('qty_out'); //Just change The Amount Of item Use In Ticket
                $stockTicket->save();
                return  array("successful"=>true, "message"=>"Item was Only reduce in Invoice");
            }
        }
    }

    function delete($ticketStockId)
    {
        $stockTicket=StockTicket::find($ticketStockId);
        $stockLocationLevel=StockLocationLevel::where("stock_id","=",$stockTicket->stock_id)->first();
        $stockLocationLevel+=$stockTicket->qty_out;
        $stockLocationLevel->save();
        $stockTicket->delete();

    }




}
