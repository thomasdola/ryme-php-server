<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/22/2016
 * Time: 10:53 AM
 */

namespace Eureka\Services\Interfaces;
use Illuminate\Support\Collection;


/**
 * Interface TrackTagServiceInterface
 * @package Eureka\Services\Interfaces
 */
interface TrackTagServiceInterface
{
    public function using(Collection $trackData);
}