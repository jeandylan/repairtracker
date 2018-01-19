<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShopCustomization;
use App\Http\Requests;

class ShopCustomizationController extends Controller
{
    //Todo Account For Empty Id 1 in table
    public function setShopColor(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        $shopCustomization->color=$request->color; //Json Should be Converted to Json to be store as laravel
        // Automatically conver request Json to php array ,resulting in error In Savinng model
        $shopCustomization->save();
        return array("successful" => true, "message" => "shop color  updated");
    }
    public function getShopColor(){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        return $shopCustomization->color;
    }
}
