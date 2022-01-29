<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function send_message_page(){
        $messages = Message::all();
        $customers = Customer::all();
        return view('sendmessage', compact('messages', 'customers'));
    }
    public function send_message(Request $request){
        $request->validate([
            'message'=>'required'
        ]);
        $message = new Message();
        $message->customer_id=$request->customer;
        $message->message=$request->message;
        $phone = Customer::where('id', $request->customer)->first();
        $client = new \GuzzleHttp\Client();
        $username = 'interviewtest@mojagate.com';
        $password= '6648f8c$1P1084';
        $token = $client->post(
            'https://api.mojasms.dev/login',
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $username ,
                    'password' => $password,
                ],
            ]
        );
        $body = $token->getBody();
       $bearer_token = json_decode($body,true);
       $data = $bearer_token['data'];
       $tokenid = $data['token'];
        $textmessage = $client->post(
            'https://api.mojasms.dev/sendsms',
            [
                'headers' => [
                    'Authorization' => 'Bearer '. $tokenid,
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'from' => 'MOJAGATE',
                    'phone' => $phone->phone,
                    'message' => $request->message,
                    'message_id' => rand(0,1000),
                    'webhook_url' => 'https://mojagate.com/sms-webhook',
                ],
            ]
        );
        $textbody = $textmessage->getBody();
        $status = json_decode($textbody, true);
        $message->status=$status['status'];
        print_r(json_decode((string) $textbody));
        $message->save();
        return back()->with('success', "Message Sent Successfully");

    }
}
