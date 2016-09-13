<?php

namespace App\Http\Controllers;
use ClassPreloader\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Employee;
use App\Mylibs\JWTAut;

class MailController extends Controller
{
    var $subject;
    var $from;
    var $replyUrl;


    public function sentCreationMail($comment){
        $employeeSender=JWTAut::toUser(); //the login user That sent the msh
        $subject="ticket ";

        //these Are From Template
        Mail::send('emails.comment', ['from' => $employeeSender->first_name, 'ticketComment' => $comment,'replyUrl'=>'http://localhost:8000/customerReply'], function($message) use ($subject)
        {
            $message->setSubject($subject);


            $message->to('dylanblais1@gmail.com')->cc('dylanblais1@gmail.com');

            //$message->attach($pathToFile);
        });
    }


    public function smtpMail(){






    }
}
