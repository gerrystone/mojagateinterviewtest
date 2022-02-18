<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class MojagateService
{
    private $guzzleClient;

    public function __construct(){
        $this->guzzleClient=new Client();
    }

    private function sendRequest(string $url,array $headers,array $jsonBody){
        return $this->guzzleClient->post(
            $url,
            [
                'headers'=>$headers,
                'json'=>$jsonBody
            ]
        );
    }

    /**
     * @throws \Exception
     */
    private function apiAuthentication(){
        //check if the token is cached and return it.
        $cachedToken = Cache::get('mojagate_token');
        if($cachedToken!=null) return $cachedToken;

        $response = $this->sendRequest(
            'https://api.mojasms.dev/login',
        [ 'Accept' => 'application/json',],
        ['email' => config('app.username') , 'password' => config('app.password')]);
        if($response->getStatusCode()==200){
            $token=json_decode($response->getBody())->data->token;
            Cache::put('mojagate_token',$token,now()->addMinutes(20));
            return $token;
        }
        throw new \Exception("Api Authentication failed.");
    }

    /**
     * @throws \Exception
     */
    public function sendMessage(string $phone, string $message){

        $token = $this->apiAuthentication();
        $response = $this->sendRequest(
            'https://api.mojasms.dev/sendsms',
            ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json'],
            ['from' => 'MOJAGATE',
                'phone' => $phone,
                'message' => $message,
                'message_id' => rand(0, 1000),
                'webhook_url' => 'https://mojagate.com/sms-webhook']
        );
        if($response->getStatusCode()==200){
            return json_decode($response->getBody());
        }

    }
}
