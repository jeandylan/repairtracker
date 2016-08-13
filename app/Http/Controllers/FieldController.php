<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\TxtField;

use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App;

class FieldController extends Controller
{
    public function createTxtField($formName) //create a new Field For A form
    {


    }

    public function getFormFields($formName){
        return  TxtField::where('form_name', '=', $formName)->get();

    }
    
    public function getFieldsDetails($formName,$entityID)
    {
        $fields = new TxtTicket;
        $fields = TxtField::where('form_name', '=', $formName)->get();
        $out = array();
        foreach ($fields as $field){
            array_push($out, $field->fieldData()->get());
        }
        return $out;
    }

    public function update($id){
       
        
    }
}
