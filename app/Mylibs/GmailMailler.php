<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 9/13/16
 * Time: 2:47 AM
 */

namespace App\Mylibs;


class GmailMailler
{
    public function sentMail($comment){
        \Config::set('mail.username', 'dylanblais1@gmail.com'); // default
        \Config::set('mail.password','jtm6310814');
        \Config::set('mail.from.name','joe ');
        \Config::set('mail.from.address','dylanblais1@gmail.com');

        $employeeSender=JWTAut::toUser(); //the login user That sent the msh
        $subject="ticket ";

        Mail::send('emails.comment', ['from' => $employeeSender, 'ticketComment' => $comment,'replyUrl'=>'http://localhost:8000/customerReply'], function($message) use ($subject)
        {
            $message->setSubject($subject);


            $message->to('dylanblais1@gmail.com')->cc('dylanblais1@gmail.com');

            //$message->attach($pathToFile);
        });
    }

}