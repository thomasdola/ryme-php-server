<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/7/2016
 * Time: 6:53 PM
 */

namespace Eureka\Repositories;


class Country
{
    /**
     * @var \App\Country
     */
    private $country;

    /**
     * @param \App\Country $country
     */
    public function __construct(\App\Country $country){
        $this->country = $country;
    }

    /**
     * @param $phone_code
     * @return mixed
     */
    public function getName($phone_code)
    {
        $country = $this->country->where('phone_code', $this->sanitize($phone_code))->first();
        return $country->nice_name;
    }

    /**
     * @param $phone_code
     * @return string
     */
    private function sanitize($phone_code)
    {
        return substr($phone_code, 1);
    }
}