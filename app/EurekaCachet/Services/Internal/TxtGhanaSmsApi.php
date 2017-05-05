<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/30/2016
 * Time: 12:06 PM
 */

namespace Eureka\Services\Internal;
use Illuminate\Http\Exception\HttpResponseException;
use Mockery\Exception;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;


/**
 * Class TxtGhanaSmsApi
 * @package Eureka\Services\Internal
 */
class TxtGhanaSmsApi
{
    /**
     *
     */
    const TEXT_URL = "http://txtconnect.co/api/send/";

    /**
     * @var null
     */
    protected $token;

    /**
     * @var
     */
    protected $from;

    /**
     * @var
     */
    protected $to;

    /**
     * @var
     */
    protected $msg;

    /**
     * @var string
     */
    protected $field_string = "";

    /**
     * @param null $token
     */
    public function __construct( $token = null ){
        if( $token == null){
            $this->token = env('SMS_API_TOKEN');
        }
        $this->token = $token;
    }

    /**
     * @param $senderId
     * @return $this
     */
    public function setSenderId($senderId)
    {
        $this->from = $senderId;
        return $this;
    }

    /**
     * @param $messageBody
     * @return $this
     */
    public function setMessageBody($messageBody)
    {
        $this->msg = $messageBody;
        return $this;
    }

    /**
     * @param $phone_number
     * @return $this
     */
    public function setReceiverPhone($phone_number)
    {
        $this->to = $phone_number;
        return $this;
    }

    /**
     * @return bool
     */
    public function send()
    {
        $fields = $this->prepareFields();
        foreach ($fields as $key => $value) {
            $this->field_string .= $key . '=' . $value . '&';
        }
        rtrim($this->field_string, '&');
        $result = $this->initCurl($fields);
        $data = json_decode($result);
        if( ! $data ){
            throw new ServiceUnavailableHttpException();
        }
        try{
            $response = $this->checkResult($data);
        }catch (Exception $e){
            throw $e;
        }
        return $response;
    }

    /**
     * @return array
     */
    private function prepareFields()
    {
        return $fields = [
            'token' => urlencode($this->token),
            'msg' => $this->msg,
            'from' => $this->from,
            'to' => $this->to,
        ];
    }

    /**
     * @param $data
     * @return bool
     */
    private function checkResult($data)
    {
        if ($data->error == "0") {
            return true;
        } else {
            throw new HttpResponseException($data->response);
        }
    }

    /**
     * @param $fields
     * @return mixed
     */
    private function initCurl($fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::TEXT_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->field_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}