<?php

namespace App\Http\Controllers;
use ClassPreloader\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Employee;
use App\Mylibs\JWTAut;
use App\Customer;

class MailController extends Controller
{
    var $subject;
    var $from;
    var $replyUrl;


    public function sentCreateTicketMail()
    {

            $employeeSender = JWTAut::toUser(); //the login user That sent the will sent the msg
            \Config::set('mail.password', 'jtm6310814');
            \Config::set('mail.username', 'dylanblais1@gmail.com');
            \Config::set('mail.from.address', 'dylanblais1@gmail.com');
            \Config::set('mail.from.name', $employeeSender->first_name);
            $subject = "SOME SUBJECT";
            //these Are From Template
            Mail::send('emails.ticket', ['emailFooter' => "from : $employeeSender->first_name", 'emailBody' => "you Have A Ticket At shop name",
                'customerName' => 'joe', 'emailSubject' => "ticket Creation", 'emailTitle' => 'Subjectdfcdfc'], function ($message) use ($subject) {
                $message->setSubject($subject);
                $message->to('dylanblais1@gmail.com')->cc('dylanblais1@gmail.com');

            });

    }

    public function sentInvoiceMail(Request $request){
        $employeeSender = JWTAut::toUser(); //the login user That sent the will sent the msg
        \Config::set('mail.password', 'jtm6310814');
        \Config::set('mail.username', 'dylanblais1@gmail.com');
        \Config::set('mail.from.address', 'dylanblais1@gmail.com');
        \Config::set('mail.from.name', $employeeSender->first_name);
        $subject = "Invoice";
        $emailAddresses=$request->emailAddresses;

        foreach($emailAddresses as $emailAddress){

            Mail::raw("Invoice below", function($message) use ($emailAddress,$request)
            {
                $message->setSubject("invoice");
                $message->to($emailAddress);
                $binary = base64_decode($request->file); //Angular sents Base 64 Need To Decode It

                $message->attachData($binary,'invoice.pdf'); //Attach it to Email and give it a name
            });
            return ['success'=>true];


        }
    }

    public function sentEstimationMail(Request $request){
        $employeeSender = JWTAut::toUser(); //the login user That sent the will sent the msg
        \Config::set('mail.password', 'jtm6310814');
        \Config::set('mail.username', 'dylanblais1@gmail.com');
        \Config::set('mail.from.address', 'dylanblais1@gmail.com');
        \Config::set('mail.from.name', $employeeSender->first_name);
        $subject = "Invoice";
        $emailAddresses=$request->emailAddresses;

        foreach($emailAddresses as $emailAddress){

            Mail::raw("Invoice below", function($message) use ($emailAddress,$request)
            {
                $message->setSubject("estimation");
                $message->to($emailAddress);
                $binary = base64_decode($request->file); //Angular sents Base 64 Need To Decode It

                $message->attachData($binary,'invoice.pdf'); //Attach it to Email and give it a name
            });
            return  array("successful"=>false, "message"=>"An error Db");


        }
    }
    public function sentPurchaseOrderMail(Request $request){
        $employeeSender = JWTAut::toUser(); //the login user That sent the will sent the msg
        \Config::set('mail.password', 'jtm6310814');
        \Config::set('mail.username', 'dylanblais1@gmail.com');
        \Config::set('mail.from.address', 'dylanblais1@gmail.com');
        \Config::set('mail.from.name', $employeeSender->first_name);
        $subject = "Purchase Order";
        $emailAddresses=$request->emailAddresses;

        foreach($emailAddresses as $emailAddress){

            Mail::raw("Purchase Order below", function($message) use ($emailAddress,$request)
            {
                $message->setSubject("purchase Order");
                $message->to($emailAddress);
                $binary = base64_decode($request->file); //Angular sents Base 64 Need To Decode It

                $message->attachData($binary,'purchaseOrder.pdf'); //Attach it to Email and give it a name
            });
            return ['success'=>true];
        }
    }






    public function smtpMail(){
/*
        $subject="ticket created ";

       \Config::set('mail.password','jtm6310814');
        \Config::set('mail.username','dylanblais1@gmail.com');
        \Config::set('mail.from.address','dylanblais1@gmail.com');
        \Config::set('mail.from.name','joe');

        //these Are From Template
        Mail::send('emails.ticket',  ['emailFooter' =>"from : dylan", 'emailBody' => "you Have A Ticket At shop name",
            'customerName'=>'joe','emailSubject'=>"ticket Creation",'emailTitle'=>'Subjectdfcdfc'], function($message) use ($subject)
        {
            $message->setSubject($subject);


            $message->to('dylanblais1@gmail.com')->cc('dylanblais1@gmail.com');

        });
*/
    }

}
