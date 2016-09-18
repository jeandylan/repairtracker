<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketComment;
use App\AllEmployee;
use App\Employee;
use App\Mylibs\JWTAut;
use App\Ticket;
use App\Mylibs\GmailMailler;
use App\Mylibs\TwilloSms;
use App\Http\Requests;

class TicketCommentController extends Controller
{
    public function get($ticketId){
        $comments=TicketComment::where('ticket_id','=',$ticketId)->get(); //all comments for ticket
        $output=[];
        foreach ($comments as $comment){
            if($ticketAuthor=Employee::find($comment->employee_id)) {
                $comment["author"]=array("first_name"=>$ticketAuthor->first_name,"last_name"=>$ticketAuthor->last_name,"id"=>$ticketAuthor->id);
                array_push($output,$comment);
            }
            else{
                if($ticketAuthor=AllEmployee::find($comment->employee_id)) {
                    $comment["author"] = array("first_name" => $ticketAuthor->first_name, "last_name" => $ticketAuthor->last_name,
                        "id" => $ticketAuthor->id,'transferred' => true, 'shop_location' => $ticketAuthor->shop_location);
                    array_push($output, $comment);
                }
                else {
                    array_push($output, $comment);
                }
            }
        }
        return $output;

    }
    public function create($ticketId,Request $request){
        try {
            if (isset($request->comment)) { //if it has a comment Proceed

                $employee = JWTAut::toUser();
                $ticket=Ticket::find($ticketId);
                $customer=$ticket->customer()->first();
                $comment = new TicketComment;

                $comment->ticket_id = $ticketId;
                $comment->employee_id = $employee->id;
                $comment->comment = $request->comment;

                if ($request->isEmail ) { //check that sent to Email To cutomer is checked
                    $comment->to_customer=1;
                    $emailSender=new GmailMailler();
                    $emailSender->sentCommentEmail($customer->id,$request->comment);
                }
                if($request->isSms){
                    $comment->to_customer=1;
                    $sms=new TwilloSms();
                    $sms->sent('+23054900594',$request->comment); //need to change Number
                }
                $comment->save();
                return array("successful" => true, "message" => "comment was posted");
            }
            else{ //Does not have a  comment,sent an error Msg
                return response()->json(['error' => "comments cannot be blank"], 404);
            }
        }
        catch (\Exception $e){ //Error Cache ,ent error msg
            return response()->json(['error' => "not login Cannot Post Comment :-or other reasons"], 404);
        }
    }

    public function delete($ticketId){

        $ticketComment=TicketComment::find($ticketId);
        if(!$ticketComment)return response()->json(['error' => "Task not found :-or other reasons"], 404);
        $ticketComment->delete();
        return array("successful" => true, "message" => "comment was deleted");

    }
}
