<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomTextFieldData;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class CustomTextFieldDataController extends Controller
{

    public function update($id){
        $txtFieldData = CustomTextFieldData::find($id);
        $txtFieldData->field_data=Input::get('field_data');
        $txtFieldData->save();
        return  array("successful"=>true, "message"=>"field was updated");
    }
    public function create(){
        $txtFieldData = new CustomTextFieldData(Input::all());
        //As data was  send with Dataname that correspond to that in Db ,no need to precise what input goes in what table field(row),(laravel Figure it out)
        $txtFieldData->save();
        return array("successful" => true, "message" => "field was created");
    }
}
