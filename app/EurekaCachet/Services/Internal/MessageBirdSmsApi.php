<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/14/2016
 * Time: 10:40 AM
 */

namespace Eureka\Services\Internal;


use Eureka\Services\Interfaces\SmsApiInterface;
use Exception;
use MessageBird\Client;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\BalanceException;
use MessageBird\Objects\Message;

class MessageBirdSmsApi implements SmsApiInterface
{

    private $bird;

    private $message;

    const SENDER_ID = "RYME";

    public function __construct()
    {
        $this->bird = new Client(env('SMS_API_TOKEN_MB'));
        $this->message = new Message();
    }

    /**
     * @param $phoneNumber
     * @param $verification_code
     */
    public function send($phoneNumber, $verification_code)
    {
        $this->message->originator = self::SENDER_ID;
        $this->message->recipients = [$phoneNumber];
        $this->message->body = $this->buildMessageBody($verification_code);
        try{
            $result = $this->bird->messages->create($this->message);
            return $result;
        }catch (AuthenticateException $e ){
            throw $e;
        }catch (BalanceException $e){
            throw $e;
        }catch (Exception $e ){
            throw $e;
        }
    }

    /**
     * @param $verification_code
     * @return string
     */
    private function buildMessageBody($verification_code)
    {
        return "Hello! Welcome to Ryme. Your code is : {$verification_code}";
    }
}