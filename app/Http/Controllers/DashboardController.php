<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Estimation;
use App\Invoice;
use Illuminate\Http\Request;
use App\Ticket;
use App\Http\Requests;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function numberTicketForPeriod(Request $request){

        $dataStartDate=Carbon::parse($request->startDate);
        $now=Carbon::now();
        $output=[];
        while($dataStartDate < $now){

            $ticketCount=Ticket::whereBetween( 'created_at',[$dataStartDate->toDateTimeString(),$dataStartDate->addMonth()->toDateTimeString()])->get()->count();
            $statData=['endDate'=>$dataStartDate->toDateString(),"amount"=>$ticketCount];
            array_push($output,$statData);
        }
        return $output;

    }

    public function numberInvoiceForPeriod(Request $request){

        $dataStartDate=Carbon::parse($request->startDate);
        $now=Carbon::now();
        $output=[];
        while($dataStartDate < $now){

            $invoiceCount=Invoice::whereBetween( 'created_at',[$dataStartDate->toDateTimeString(),$dataStartDate->addMonth()->toDateTimeString()])->get()->count();
            $statData=['endDate'=>$dataStartDate->toDateString(),"amount"=>$invoiceCount];
            array_push($output,$statData);
        }
        return $output;

    }

    public function numberEstimationForPeriod(Request $request){

        $dataStartDate=Carbon::parse($request->startDate);
        $now=Carbon::now();
        $output=[];
        while($dataStartDate < $now){

            $estimationCount=Estimation::whereBetween( 'created_at',[$dataStartDate->toDateTimeString(),$dataStartDate->addMonth()->toDateTimeString()])->get()->count();
            $statData=['endDate'=>$dataStartDate->toDateString(),"amount"=>$estimationCount];
            array_push($output,$statData);
        }
        return $output;

    }
    public function numberNewCustomerForPeriod(Request $request){

        $dataStartDate=Carbon::parse($request->startDate);
        $now=Carbon::now();
        $output=[];
        while($dataStartDate < $now){

            $customerCount=Customer::whereBetween( 'created_at',[$dataStartDate->toDateTimeString(),$dataStartDate->addMonth()->toDateTimeString()])->get()->count();
            $statData=['endDate'=>$dataStartDate->toDateString(),"amount"=>$customerCount];
            array_push($output,$statData);
        }
        return $output;
    }

    public function  amountOfInvoiceForPeriod(Request $request){
        $dataStartDate=Carbon::parse($request->startDate);
        $now=Carbon::now();
        $output=[];
        while($dataStartDate < $now){
            $invoices=Invoice::whereBetween( 'created_at',[$dataStartDate->toDateTimeString(),$dataStartDate->addMonth()->toDateTimeString()])->get();
            $labourCostForPeriod=0;
            $stockCostForPeriod=0;
            foreach ($invoices as $invoice){
               $labours=$invoice->labour()->get(); //get labour Associated

                if($ticketStocks=$invoice->ticket()->first()){ //assure Invoice have Ticket (due to domain/Subdomain Config ,ignoring ticket wronly assign to D.N)
                    $ticketStocks=$ticketStocks->stockOnly()->get(); //Assure StockOnly is not Done on null
                    foreach ($labours as $labour){
                        $labourCostForPeriod+=$labour->cost;
                    }
                    foreach ($ticketStocks as $ticketStock){
                        $stockCostForPeriod+=$ticketStock->selling_price;
                    }

                }

            }
            $statData=['endDate'=>$dataStartDate->toDateString(),"amount"=>$labourCostForPeriod+$stockCostForPeriod];
            array_push($output,$statData);
        }
        return $output;
    }
}
