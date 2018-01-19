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
        if ($request->has('name') && $request->has('cost') ) {
           if($estimation=Estimation::where('ticket_id','=',$ticketId)->first()){
               $estimationLabour=new EstimationLabour(['cost'=>$request->cost,'name'=>$request->name,'estimation_id'=>$estimation->id]);
               $estimationLabour->save();
               return  array("successful"=>true, "message"=>"Estimation created + item added");
           }
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
        if($estimation=Estimation::where('ticket_id','=',$ticketId)->first()){
           $stock=Stock::find($request->input("id"));
            $estimationItem=new EstimationItem(['estimation_id'=>$estimation->id,'stock_id'=>$stock->id,'product_name'=>$stock->product_name,'selling_price'=>$stock->selling_price,
            'qty_out'=>$request->input('qty_out')]);
            $estimationItem->save();
            return  array("successful"=>true, "message"=>"stock added");
        }
        else{
            $newEstimation=new Estimation();
            $newEstimation->ticket_id=$ticketId;
            $newEstimation->save();
            $stock=Stock::find($request->input("id"));
            $estimationItem=new EstimationItem(['estimation_id'=>$newEstimation->id,'stock_id'=>$stock->id,'product_name'=>$stock->product_name,'selling_price'=>$stock->selling_price,
                'qty_out'=>$request->input('qty_out')]);
            $estimationItem->save();
            return  array("successful"=>true, "message"=>"Estimation created + item added");

        }
    }




    public function updateEstimationItem($estimationItemId,Request $request){
        $estimationItem=EstimationItem::find($estimationItemId);
        $estimationItem->update($request->all());
    }




    public function deleteEstimationItem($estimationItem){ ///same as labour
        $estimationItem=EstimationItem::find($estimationItem);
        $estimationItem->delete();
    }
}
