<?php

namespace App\Http\Controllers;

use App\Jobs\SendSmsJob;
use App\Models\Customer;
use App\Models\Message;
use App\Services\MojagateService;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /* Display Send Message Page */
    /**
     * @var MojagateService
     */
    private $mojagateService;

    public function __construct(MojagateService $mojagateService)
    {
        $this->mojagateService=$mojagateService;
    }

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
        $message->status="pending";
        $message->save();
        SendSmsJob::dispatch($message->id);
        return back()->with('success', "Message queued for processing.");
    }
}
