<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/30/2016
 * Time: 11:12 AM
 */

namespace Eureka\Services\Interfaces;


interface SmsApiInterface
{
    public function send($phoneNumber, $verification_code);
}