<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 9/13/16
 * Time: 2:47 AM
 */

namespace App\Mylibs;
use Illuminate\Support\Facades\Mail;
use App\Mylibs\JWTAut;
use App\Employee;
use League\Flysystem\Exception;

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


    public function SentTicketCreation($to,$cutomerName,$emailSubject,$emailTitle,$emailBody){
        //Need Integration from SaasAdmin
        try {
            \Config::set('mail.username', 'dylanblais1@gmail.com'); // default
            \Config::set('mail.password', 'jtm6310814');
            \Config::set('mail.from.address', 'dylanblais1@gmail.com');

            $employeeSender = JWTAut::toUser(); //the login user That sent the msh
            if ($employeeSender) {
                \Config::set('mail.from.name', $employeeSender->first_name);


                Mail::send('emails.ticket', ['emailFooter' => "from :" . $employeeSender->first_name, 'emailBody' => $emailBody,
                    'customerName' => $cutomerName, 'emailSubject' => $emailSubject, 'emailTitle' => $emailTitle], function ($message) use ($emailSubject, $to) {
                    $message->setSubject($emailSubject);
                    $message->to($to)->cc($to);
                });
                return "email sent to : $to \n";
            }
        }
        catch (Exception $e){
            return "email caanot be sent check Gmail address And Password \n";

        }
    }

}
//TODO Integrate with SAAS ADMIN,obtain default sender Email, and company email password From SAAS DB,BY USING CONFIG::set(.....)