<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/13/2016
 * Time: 7:30 AM
 */

namespace Eureka\Services\Interfaces;


interface NotificationServiceInterface
{
    /**
     * @param $channel
     * @param $message
     * @param $event
     * @return mixed
     */
    public function publish($channel, $message, $event);

    /**
     * @param $user_id
     * @param $channel
     * @return mixed
     */
    public function subscribe($user_id, $channel);

    /**
     * @param $user_id
     * @param $channel
     * @return mixed
     */
    public function unsubscribe($user_id, $channel);


    /**
     * @param $to
     * @param array $data
     * @return mixed
     */
    public function ptest($to, array $data);
}