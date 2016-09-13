<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Service_Gmail;
use Google_Client;
use Google_Service_Drive;
use App\SaasCompany;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class GoogleController extends Controller{

    public function companyGoogleAuth()
    {
        $client = new Google_Client();
        $client->setApplicationName("saasRepair");
        $client->setAuthConfigFile(storage_path() . "/json/client_secrets.json");
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setApprovalPrompt('force');
        $client->addScope(Google_Service_Gmail::MAIL_GOOGLE_COM, Google_Service_Gmail::GMAIL_SEND, Google_Service_Gmail::GMAIL_COMPOSE, Google_Service_Gmail::GMAIL_READONLY, Google_Service_Gmail::GMAIL_INSERT);
        $redirect_uri = 'http://localhost:8000/googleAuth';
        $client->setRedirectUri($redirect_uri);
        $client->setState("emtel");

        $client->setAccessType("offline");
        if (isset($_GET['code']))
        {
            //auth ,now save token in DB
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->saveAuthInDb($token, $_GET['state']);
            echo "oko";
        }
        else
            {
            $auth_url = $client->createAuthUrl();
            echo "<a href='$auth_url'>visit page </a>";
        }
    }

    public function saveAuthInDb($token, $state)
    {
        $company = SaasCompany::find('emtel');
        $serializeToken = serialize($token);
        if ($company->google_token !== $serializeToken) {
            $company->google_token = $serializeToken;
            $company->save();
        }
    }


    function sentEmail(){
        $company = SaasCompany::find('emtel');
        $serializeToken=$company->google_token;
        $googleToken=unserialize($serializeToken);
        $client = new Google_Client(); //set the Client
        $client->setAccessToken($googleToken);

        $service =new Google_Service_Gmail($client);
        $service->users_messages->send('me',$this->createTextMessage("repairtrackerutm@gmail.com","dylanblais1@gmail.com","teting","testMyMsg"))->execute;
        $client->refreshToken($googleToken);
        $this->saveAuthInDb($client->getAccessToken(),"emtel");
    }
    function createTextMessage($from,$to,$subject,$content){
        $strSubject = 'Test mail using GMail API' . date('M d, Y h:i:s A');
        $strRawMessage = "From: $from\r\n";
        $strRawMessage .= "To: $to\r\n";
        $strRawMessage .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
        $strRawMessage .= "MIME-Version: 1.0\r\n";
        $strRawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
        $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $strRawMessage .= "$content\r\n";
// The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg=new \Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        return $msg;
    }

    public function  getCompanyDetails(){
        $com=SaasCompany::where('company_name','=','emtel')->get();
        return $com;
    }
}
