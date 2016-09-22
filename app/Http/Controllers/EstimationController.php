<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use App\Estimation;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Ticket;
use App\Stock;
use App\EstimationItem;
use App\EstimationLabour;
use App\Http\Requests;

class EstimationController extends Controller
{
    public function get($ticketId){
        $ticket=Ticket::find($ticketId);
        $estimation=$ticket->estimation()->first();
        if(!$ticket || !$estimation) return  response()->json(['error'=>'error,Estimation not created'], 404); // Status code here
        return array("stocks"=>$estimation->estimationItem()->get(),"labours"=> $estimation->estimationLabour()->get());

    }

    public function createEstimationLabour($ticketId,Request $request){
        if($estimation=Ticket::find($ticketId)->estimation()->first()){
            $estimation->estimationLabour()->create($request->all());
            return  array("successful"=>true, "message"=>"Labour Cost added");
        }
        else{
            $estimation=new Estimation($ticketId);
            $estimation->estimationLabour()->create($request->all());
            return  array("successful"=>true, "message"=>"Estimation created + labour cost added");

        }
    }
    public function updateEstimationLabour($estimationLabourId,Request $request){
        $estimationLabour=EstimationLabour::find($estimationLabourId);
        $estimationLabour->update( $request->all());
    }

    public function deleteEstimationLabour($estimationLabour){
        $estimationLabour=EstimationLabour::find($estimationLabour);
        $estimationLabour->delete();
    }

    public function createEstimationItem($ticketId,Request $request){

        if($estimation=Ticket::find($ticketId)->estimation()->first()){
            $stock=Stock::find($request->input("id"));
            $estimation->estimationItem()->create(['stock_id'=>$stock->id,'product_name'=>$stock->product_name,'selling_price'=>$stock->selling_price,
            'qty_out'=>$request->input('qty_out')]);
            return  array("successful"=>true, "message"=>"stock added");
        }
        else{
            $estimation=new Estimation($ticketId);
            $stock=Stock::find($request->input("stock.id"));
            $estimation->estimationItem()->create(['stock_id'=>$stock->id,'product_name'=>$stock->product_name,'selling_price'=>$stock->selling_price,
                'qty_out'=>$request->input('qty_out')]);
            return  array("successful"=>true, "message"=>"Estimation created + item added");

        }
    }




    public function updateEstimationItem($estimationItemId,Request $request){
        $estimationItem=EstimationItem::find($estimationItemId);
        $estimationItem->update($request->all());
    }




    public function deleteEstimationItem($estimationItem){
        $estimationItem=EstimationItem::find($estimationItem);
        $estimationItem->delete();
    }
}
