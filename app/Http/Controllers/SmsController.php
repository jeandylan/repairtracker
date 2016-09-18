<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\IpMessagingGrant;
use App\Http\Requests;
use App\Mylibs\TwilloSms;
use Twilio\Exceptions\TwilioException;

class SmsController extends Controller
{
    public function sent(Request $request){
        $message=$request->input('message');
        $sms=new TwilloSms();
        try {
            $sms->sent('+23054900594', $message);    //can only do sms to 5400594 unless added to  www.twilio.com/console/phone-numbers/verified
            return array("successful" => true, "message" => "message Sent ");
        }
        catch (TwilioException $e){
            return $e->getMessage()."or number not register for sending Twillo";
        }

    }

}
