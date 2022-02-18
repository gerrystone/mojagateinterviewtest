<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Message;
use App\Services\MojagateService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mockery\Exception;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $mojagateService;
    private $messageId;
    public function __construct(int $messageId)
    {
        $this->mojagateService=new MojagateService();
        $this->messageId=$messageId;
    }

    public function handle()
    {
        $message = Message::whereId($this->messageId)->first();
        $customer = Customer::whereId($message->customer_id)->first();
        try {
            $object = $this->mojagateService->sendMessage($customer->phone, $message->message);
            $message->status=$object->status;
            $message->save();
        } catch (\Exception $e) {
        }
    }
}
