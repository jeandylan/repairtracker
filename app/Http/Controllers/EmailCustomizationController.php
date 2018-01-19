<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShopCustomization;
use App\Http\Requests;
use Stevebauman\Purify;

class EmailCustomizationController extends Controller
{
    //Todo Account For Empty Id 1 in table
    public function saveEstimationEmailHeader(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        $shopCustomization->estimation_email_header= \Purify::clean($request->estimation_email_header);
        $shopCustomization->save();
        return array("successful" => true, "message" => "Estimation header updated");
    }
    public function getEstimationEmailHeader(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        return $shopCustomization->estimation_email_header;
    }

    public function saveEstimationEmailFooter(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        $shopCustomization->estimation_email_footer= \Purify::clean($request->estimation_email_footer);
        $shopCustomization->save();
        return array("successful" => true, "message" => "estimation footer was updated");

    }

    public function getEstimationEmailFooter(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        return $shopCustomization->estimation_email_footer;
    }

    public function saveInvoiceEmailHeader(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        $shopCustomization->invoice_email_header= \Purify::clean($request->invoice_email_header);
        $shopCustomization->save();
        return array("successful" => true, "message" => "invoice header was updated");
    }
    public function getInvoiceEmailHeader(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        return $shopCustomization->invoice_email_header;
    }

    public function saveInvoiceEmailFooter(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        $shopCustomization->invoice_email_footer= \Purify::clean($request->invoice_email_footer);
        $shopCustomization->save();
        return array("successful" => true, "message" => "invoice footer was updated");

    }
    public function getInvoiceEmailFooter(Request $request){
        $shopCustomization=ShopCustomization::where('id','=',1)->first();
        return $shopCustomization->invoice_email_footer;


    }
}
