<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 7:56 AM
 */

namespace Eureka\Services\Interfaces;


use App\Track;
use App\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ArtistContract
{
    /**
     * @param array $audioData
     * @param User $artist
     * @return mixed
     */
    public function uploadTrack(array $audioData, User $artist);

    /**
     * @param $photoData
     * @param User $artist
     * @return mixed
     */
    public function updateBackgroundPhoto($photoData, User $artist);

    /**
     * @param string $name
     * @param User $artist
     * @return mixed
     */
    public function updateStageName($name, User $artist);

    /**
     * @param Track $track
     * @param $downloadable
     * @return mixed
     */
    public function updateTrackDownloadable(Track $track, $downloadable);
}