<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\IpMessagingGrant;
use App\Http\Requests;

class SmsController extends Controller
{
    public function sent(){
        $sid = 'ACd7a3cc8cf4ae2faba796042089780c9b';
        $token = 'cd6895c07ae9268cde820a655a2e705e';
        $client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
            '+23054900594',
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '(201) 231-7479',
                // the body of the text message you'd like to send
                'body' => 'Hey Jenny! Good luck on the bar exam!'
            )
        );

    }

}
