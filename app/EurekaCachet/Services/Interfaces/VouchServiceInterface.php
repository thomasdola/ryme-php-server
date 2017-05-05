<?php

namespace Eureka\Services\Interfaces;
use App\User;


/**
 * Interface VouchServiceInterface
 * @package Eureka\Services\Interfaces
 */
interface VouchServiceInterface
{
    /**
     * Make a vouch request
     *
     * @param User $user
     * @return mixed
     */
    public function makeRequest(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function isAllowed(User $user);
}