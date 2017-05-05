<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Eureka\Services\Interfaces\SmsApiInterface;
use Mockery\Exception;

class SendOtp
{
    /**
     * @var SmsApiInterface
     */
    private $smsApi;

    /**
     * Create the event listener.
     *
     * @param SmsApiInterface $smsApi
     */
    public function __construct(SmsApiInterface $smsApi)
    {
        $this->smsApi = $smsApi;
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated $event
     * @return bool
     */
    public function handle(UserCreated $event)
    {
        $phone = $event->user->phone;
        $verification_code = $event->user->verification_code->code;
        try{
            $response = $this->smsApi->send($phone, $verification_code);
        }catch (Exception $e){
            throw $e;
        }
        return $response;
    }
}
