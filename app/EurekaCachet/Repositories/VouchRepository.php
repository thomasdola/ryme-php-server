<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/9/2016
 * Time: 6:39 PM
 */

namespace Eureka\Repositories;


use App\Vouch;
use App\VouchResponse;

/**
 * Class VouchRepository
 * @package Eureka\Repositories
 */
class VouchRepository
{

    /**
     * @var Vouch
     */
    private $vouch;
    /**
     * @var VouchResponse
     */
    private $vouchResponse;

    /**
     * @param Vouch $vouch
     * @param VouchResponse $vouchResponse
     */
    public function __construct(Vouch $vouch, VouchResponse $vouchResponse){
        $this->vouch = $vouch;
        $this->vouchResponse = $vouchResponse;
    }

    /**
     * @return mixed
     */
    public function getRecentRequests()
    {
        return $this->vouch->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(50);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getVouch($id)
    {
        return $this->vouch->where('uuid', $id)->first();
    }
}