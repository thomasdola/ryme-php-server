<?php

namespace Eureka\Repositories;


use App\SmsVerificationCode;

/**
 * Class VerificationCodeRepository
 * @package Eureka\Repositories
 */
class VerificationCodeRepository
{
    /**
     * @var SmsVerificationCode
     */
    private $code;

    /**
     * @param SmsVerificationCode $code
     */
    public function __construct(SmsVerificationCode $code){
        $this->code = $code;
    }

    /**
     * @param $code
     */
    public function delete($code)
    {
        $code = $this->getCode($code);
        $code->delete();
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getCode($code)
    {
        return $this->code->where('code', $code)->first();
    }

}