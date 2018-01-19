<?php

namespace App\Http\Controllers\SaasAdmin;
use App\SaasSupporter;
use DB;
use Illuminate\Http\Request;
use Validator;
use Schema;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\SaasMessages;

class SupporterController extends Controller
{
    public function all()
    {
        return SaasSupporter::all();
    }

    public function createSupporter(Request $request)
    {
        $supporter = SaasSupporter::create($request->all());

        if ($supporter == null) {
            return array("successful" => false, "message" => "Supporter was not created", "newResource" => $supporter);
        }

        return array("successful" => true, "message" => "Supporter was created", "newResource" => $supporter);

    }

    public  function getSupporter($id){
        return SaasSupporter::find($id);
    }

    public function updateSupporter($id,Request $request){
        $supporter=SaasSupporter::find($id);
        $supporter->update($request->all());
        return  array("successful"=>true, "message"=>"Supporter was updated");
    }

    public function deleteSupporter($id){
        $supporter=SaasSupporter::find($id);
        $supporter->delete();
        return  array("successful"=>true, "message"=>"Supporter was deleted");
    }

}

