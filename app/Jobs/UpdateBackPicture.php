<?php

namespace App\Jobs;


use App\User;
use Eureka\Services\Interfaces\ArtistContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateBackPicture extends AppApiJobs implements ShouldQueue
{
    /**
     * @var User
     */
    private $artist;
    /**
     * @var array
     */
    private $photoData;

    /**
     * @param array $photoData
     * @param User $artist
     */
    public function __construct(array $photoData, User $artist){
        $this->artist = $artist;
        $this->photoData = $photoData;
    }

    public function handle(ArtistContract $artistActivity)
    {
        try{
            $artistActivity->updateBackgroundPhoto($this->photoData, $this->user);
        }catch (\Exception $e){
            throw $e;
        }
    }
}