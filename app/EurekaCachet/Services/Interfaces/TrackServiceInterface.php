<?php

namespace Eureka\Services\Interfaces;


use Illuminate\Support\Collection;

/**
 * Interface TrackServiceInterface
 * @package Eureka\Services\Interfaces
 */
interface TrackServiceInterface
{
    /**
     * @param Collection $audioData
     * @return mixed
     */
    public function uploadTrack(Collection $audioData);
}