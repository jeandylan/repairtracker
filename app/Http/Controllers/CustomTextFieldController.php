<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\CustomTextField;
use Illuminate\Support\Facades\Validator;
use App;
use App\Http\Requests;

class CustomTextFieldController extends Controller
{
    public function createTxtField($formName) //create a new Field For A form
    {


    }

    public function get($formName)
    {
        return CustomTextField::where('form_name', '=', $formName)->get();

    }
    public function destroy($id)
    {
        $txtField= CustomTextField::find($id);
        $txtField->delete();
        return array("successful" => true, "message" => "Txtfield was deleted");


    }

    public function getFieldsDetails($formName, $entityID)
    {
        $fields = new  CustomTextField;
        $fields =  CustomTextField::where('form_name', '=', $formName)->get();
        $out = array();
        foreach ($fields as $field) {
            array_push($out, $field->fieldData()->get());
        }
        return $out;
    }

    public function update($id)
    {
        $field =  CustomTextField::find($id);
        $field->update(Input::all());
        return array("successful" => true, "message" => "Txtfield was updated");


    }

    public function create()
    {
        $rules = array(
            'field_name' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules); //validate input according to rule above
        if ($validator->passes()) {
            $txtField = new  CustomTextField(Input::all());
            //As data was  send with Dataname that correspond to that in Db ,no need to precise what input goes in what table field(row),(laravel Figure it out)
            $txtField->save();
            return array("successful" => true, "message" => "field was created");
        }
        else {
            return array("successful" => false,  'message' =>implode(" .\n ",$validator->errors()->all()));
        }
    }
}
