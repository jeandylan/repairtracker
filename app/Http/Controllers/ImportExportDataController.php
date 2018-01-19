<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use App\Http\Requests;
use App\Customer;
use App\Employee;
use App\AllEmployee;
use App\Stock;
use Illuminate\Support\Facades\Input;


class ImportExportDataController extends Controller
{
/*Export */
    public function customerToXml(){
        $customers=Customer::all();
        $output=[];
        foreach ($customers as $customer){
           array_push($output,['personal' => $customer->toArray(), 'addresses' => $customer->address()->get()->toArray(),
               'telephones'=>$customer->telephone()->get()->toArray(),'emails'=>$customer->email()->get()->toArray()]);
        }
        $formatter = Formatter::make($output, Formatter::ARR);
        $xml   = $formatter->toXml();
        return response($xml)->header('Content-Type', 'xml');
    }

    public function customerToJson(){
        $customers=Customer::all();
        $output=[];
        foreach ($customers as $customer){
            array_push($output,['personal' => $customer, 'addresses' => $customer->address()->get(),'telephones'=>$customer->telephone()->get(),'emails'=>$customer->email()->get()]);
        }
        $formatter = Formatter::make($output, Formatter::ARR);
        $xml   = $formatter->toJson();
        return response($xml)->header('Content-Type', 'json');
    }

    public function  employeesToXml(){
        $formatter = Formatter::make( AllEmployee::all()->toArray(), Formatter::ARR);
        $xml   = $formatter->toXml();
        return response($xml)->header('Content-Type', 'xml');
    }
    public function  employeesToJson(){
        $formatter = Formatter::make( AllEmployee::all(), Formatter::ARR);
        $xml   = $formatter->toJson();
        return response($xml)->header('Content-Type', 'json');
    }

    public  function  stockToXml(){
        $formatter = Formatter::make( Stock::all()->toArray(), Formatter::ARR);
        $xml   = $formatter->toXml();
        return response($xml)->header('Content-Type', 'xml');

    }

    public  function  stockTOJson(){
        $formatter = Formatter::make( Stock::all(), Formatter::ARR);
        $xml   = $formatter->toJson();
        return response($xml)->header('Content-Type', 'json');

    }

    public  function  supplierTOJson(){
        $formatter = Formatter::make( Supplier::all(), Formatter::ARR);
        $xml   = $formatter->toJson();
        return response($xml)->header('Content-Type', 'json');

    }
    public  function  supplierToXml(){
        $formatter = Formatter::make( Supplier::all()->toArray(), Formatter::ARR);
        $xml   = $formatter->toXml();
        return response($xml)->header('Content-Type', 'xml');

    }


    /*import*/

    public function  xmlToStocks(Request $request){
        $formatter = Formatter::make(base64_decode($request->base64), Formatter::XML);
         $arrayData  = $formatter->toArray();
        foreach ($arrayData as $items){
         foreach ($items as $stockData) {
             $stock = new Stock($stockData);
             $stock->save();
         }

        }
    }

    public function xmlToCustomers(Request $request){
        $formatter = Formatter::make(base64_decode($request->base64), Formatter::XML);
        $arrayData  = $formatter->toArray();
        foreach ($arrayData as $items){
            foreach ($items as $customerData) {
                $customer = new Customer($customerData);
                $customer->save();
            }
        }

    }

    public function xmlToSuppliers(Request $request){
        $formatter = Formatter::make(base64_decode($request->base64), Formatter::XML);
        $arrayData  = $formatter->toArray();
        foreach ($arrayData as $items){
            foreach ($items as $supplierData) {
                $supplier = new Supplier($supplierData);
                $supplier->save();
            }
        }

    }



}
