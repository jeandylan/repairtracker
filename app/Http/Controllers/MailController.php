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
