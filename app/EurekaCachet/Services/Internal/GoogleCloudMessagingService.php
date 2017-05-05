<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/21/2016
 * Time: 9:43 PM
 */

namespace Eureka\Services\Internal;


use Eureka\Services\Interfaces\NotificationServiceInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class GoogleCloudMessagingService implements NotificationServiceInterface
{
    const SEND_NOTIFICATION_BASE_URI = "https://gcm-http.googleapis.com/gcm/";
    const BATCH_UNSUB_BASE_URI = "https://iid.googleapis.com/iid/v1:batchRemove";
    const SUB_BASE_URI = "https://iid.googleapis.com/iid/v1/";

    /**
     * @param $channel
     * @param $message
     * @param $event
     * @return mixed
     * @throws Exception
     */
    public function publish($channel, $message, $event)
    {
        try{
            $this->makeSendRequest($channel, $message, $event);
        }catch (Exception $e){
            throw $e;
        }
    }

    /**
     * @param $user_id
     * @param $channel
     * @return mixed
     * @throws Exception
     */
    public function subscribe($user_id, $channel)
    {
        try{
            $this->makeSubRequest($user_id, $channel);
        }catch (Exception $e){
            throw $e;
        }
    }

    /**
     * @param $user_id
     * @param $channel
     * @return mixed
     * @throws Exception
     */
    public function unsubscribe($user_id, $channel)
    {
        try{
            $this->makeUnSubRequest($user_id, $channel);
        }catch (Exception $e){
            throw $e;
        }
    }

    /**
     * @param $channel
     * @param $message
     * @param $event
     * @return ResponseInterface
     * @throws Exception
     */
    private function makeSendRequest($channel, $message, $event)
    {
        $client = new Client($this->getOptions("send"));
        $res = $client->post('send', $this->getData($channel, $message,$event));
        if($res->getStatusCode() != 200){
            throw new Exception("Unable to make request", $res->getStatusCode());
        }
        return $res;
    }

    /**
     * @param $type
     * @return array
     */
    private function getOptions($type)
    {
        $options = ['headers' => [
            'Authorization' => 'key='.(string)env('GCM_SERVER_API_KEY'),
            'Content-Type' => 'application/json'
        ]];
        if($type == "send"){
            $options = array_add($options, "base_uri", self::SEND_NOTIFICATION_BASE_URI);
        }elseif($type == "sub"){
            $options = array_add($options, "base_uri", self::SUB_BASE_URI);
        }elseif($type == "unsub"){
            $options = array_add($options, "base_uri", self::BATCH_UNSUB_BASE_URI);
        }
        return $options;
    }

    /**
     * @param $channel
     * @param $message
     * @param $event
     * @return array
     */
    private function getData($channel, $message, $event)
    {
        return $this->prepareNotification($channel, $message, $event);
    }

    /**
     * @param $channel
     * @param $message
     * @param $event
     * @return array
     */
    private function prepareNotification($channel, $message, $event)
    {
        $to = '/topics/'.$channel;
        $collapse_key = $event;
        $data = $this->prepareDataField($message, $event);
        return [
            'verify' => false,
            'json' => [
                'to'=>$to,
                'collapse_key'=>$collapse_key,
                'data'=>$data
            ]
        ];
    }

    /**
     * @param $message
     * @param $event
     * @return array
     */
    private function prepareDataField($message, $event)
    {
        $data = [
            'event'=>$event,
            'title'=>collect($message)->get('title'),
            'body'=>collect($message)->get('body')
        ];
        if(strtolower($event) == "track_uploaded"){
            $data = array_add($data, 'track_id', collect($message)->get('track_id'));
        }elseif(strtolower($event) == "artist_joined"){
            $data = array_add($data, 'artist_id', collect($message)->get('artist_id'));
        }
        return $data;
    }

    /**
     * @param $message
     * @return array
     */
    private function prepareNotificationField($message)
    {
        return [
            'title'=>collect($message)->get('title'),
            'body'=>collect($message)->get('body')
        ];
    }

    /**
     * @param $event
     * @return array
     */
    private function prepareOptionsField($event)
    {
        return ['collapse_key'=>$event];
    }

    /**
     * @param $user_id
     * @param $channel
     * @return array
     */
    private function getBatchUnsubData($user_id, $channel)
    {
        return [
            'verify' => false,
            'json' => [
                'to' => '/topics/'.$channel,
                'registration_tokens' => [$user_id],
            ]
        ];
    }

    /**
     * @param $user_id
     * @param $channel
     * @return ResponseInterface
     * @throws Exception
     */
    private function makeUnSubRequest($user_id, $channel)
    {
        $client = new Client($this->getOptions('unsub'));
        $res = $client->post(self::BATCH_UNSUB_BASE_URI, $this->getBatchUnsubData($user_id, $channel));
        if($res->getStatusCode() != 200){
            throw new Exception("Unable to make request", $res->getStatusCode());
        }
        return $res;
    }

    /**
     * @param $user_id
     * @param $channel
     * @return ResponseInterface
     * @throws Exception
     */
    private function makeSubRequest($user_id, $channel)
    {
        $client = new Client($this->getOptions("sub"));
        $topic_name = $channel;
        $iid_token = $user_id;
        $res = $client->post("https://iid.googleapis.com/iid/v1/{$iid_token}/rel/topics/{$topic_name}");
        if($res->getStatusCode() != 200){
            throw new Exception("Unable to make request", $res->getStatusCode());
        }
        return $res;
    }

    /**
     * @param $to
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function ptest($to, array $data)
    {
        $client = new Client($this->getOptions("send"));
        $res = $client->post('send', $this->simpleNotify($to, $data));
        if($res->getStatusCode() != 200){
            throw new Exception("Unable to make request", $res->getStatusCode());
        }
        return $res;
    }

    /**
     * @param $to
     * @param array $data
     * @return array
     */
    private function simpleNotify($to, array $data)
    {
        return [
            'json'=>[
                'data'=>$data,
                'to'=>$to
            ]
        ];
    }
}