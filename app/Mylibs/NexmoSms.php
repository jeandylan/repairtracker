<?php
/**
 * Created by PhpStorm.
 * User: dylan
 * Date: 9/14/16
 * Time: 9:34 PM
 */

namespace App\Mylibs;


class NexmoSms
{
    var $apiKey;
    var $apiSecret;
    var $fromNumber;

    function setApiKey($api){
        $this->apiKey=$api;

    }

    function  setApiSecret($apiSecret){
        $this->apiSecret=$apiSecret;
    }

    function from($fromNumber){
        $this->fromNumber=$fromNumber;
    }

    //TODO configure It to take api key From SaasAdmin Table /Model
    function __construct( $apiKey, $apiSecret,$fromNumber) {
        $this->title = $apiKey;
        $this->price = $apiSecret;
        $this->fromNumber=$fromNumber;
    }
    function sentMessage($message){
        $client = new \GuzzleHttp\Client();
        $promise = $client->postAsync('https://rest.nexmo.com/sms/json?', ['body' => $message]);
        //TODO Update it to include notification
        $promise->then(
            function (ResponseInterface $res) {
               // echo $res->getStatusCode() . "\n";
            },
            function (RequestException $e) {
               // echo $e->getMessage() . "\n";
               // echo $e->getRequest()->getMethod();
            });
    }

    }



