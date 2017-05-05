<?php

namespace Eureka\ThirdPartyServices;

use Eureka\Services\Interfaces\SmsApiInterface;
use Eureka\Services\Internal\TxtGhanaSmsApi;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class SmsApi
 * @package Eureka\ThirdPartyServices
 */
class SmsApi implements SmsApiInterface
{
    /**
     *
     */
    const SENDER_ID = "RYME";

    /**
     * @param $phoneNumber
     * @param $verification_code
     * @return bool
     */
    public function send($phoneNumber, $verification_code)
    {
        $message = $this->buildMessageBody($verification_code);
        try{
            $response = $this->requestSms($phoneNumber, $message);
        }catch (Exception $e){
            throw $e;
        }
        return $response;
    }

    /**
     * @param $verification_code
     * @return string
     */
    protected function buildMessageBody($verification_code)
    {
        $template = "Hello! Welcome to Ryme. Your code is : {$verification_code}";
        return $template;
    }

    /**
     * @param $phoneNumber
     * @param $message
     * @return bool
     */
    protected function requestSms($phoneNumber, $message)
    {
        $sender_id = self::SENDER_ID;
        $auth_key = env('SMS_API_TOKEN');
        $text = (new TxtGhanaSmsApi($auth_key))
            ->setSenderId($sender_id)
            ->setReceiverPhone($phoneNumber)
            ->setMessageBody($message);

        try{
            $feedBack = $text->send();
        }catch (Exception $e){
            throw $e;
        }
        return $feedBack;
    }
}