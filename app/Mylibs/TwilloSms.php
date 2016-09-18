<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 9/14/16
 * Time: 10:31 PM
 */

namespace App\Mylibs;
use League\Flysystem\Exception;
use Twilio\Rest\Client;

class TwilloSms
{
    var $id = 'ACd7a3cc8cf4ae2faba796042089780c9b';
    var $token = 'cd6895c07ae9268cde820a655a2e705e';
    var $from='(201) 231-7479'; //The number Twillo Provided
    var $message;


    function sent($to,$message){

        $client = new Client($this->id, $this->token);
// Use the client to do fun stuff like send text messages!
        $client->messages->create(

            $to, // the number you'd like to send the message to (should be a verify number from https://www.twilio.com/console/phone-numbers/verified
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $this->from,
                // the body of the text message you'd like to send
                'body' => $message
            ));

    }

}