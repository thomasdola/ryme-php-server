<?php

namespace Eureka\Services\Internal;


use App\User;
use Carbon\Carbon;
use Eureka\Services\Interfaces\TrackServiceInterface;
use Illuminate\Support\Collection;

class TrackService implements TrackServiceInterface
{
    /**
     * @var User
     */
    private $artist;

    /**
     * @param User $artist
     */
    public function __construct(User $artist){
        $this->artist = $artist;
    }

    /**
     * @param Collection $audioData
     * @return mixed
     */
    public function uploadTrack(Collection $audioData)
    {
        // TODO: Implement uploadTrack() method.
    }
}