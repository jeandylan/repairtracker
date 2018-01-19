<?php

namespace App\Http\Controllers\SaasAdmin;
use DB;
use Illuminate\Http\Request;
use Validator;
use Schema;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\SaasMessages;

class MessagesController extends Controller
{
    public function all()
    {
        return SaasMessages::all();
    }

    public function createMessage(Request $request)
    {
        $message = SaasMessages::create($request->all());

        if ($message == null) {
            return array("successful" => false, "message" => "Message was not created", "newResource" => $message);
        }

        return array("successful" => true, "message" => "Message was created", "newResource" => $message);

    }

    public  function getMessage($id){
        return SaasMessages::find($id);
    }

    public function deleteSupporter($id){
        $message=SaasMessages::find($id);
        $message->delete();
        return  array("successful"=>true, "message"=>"Message was deleted");
    }

}

