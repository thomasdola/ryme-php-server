<?php

namespace App\Jobs;

use App\Events\TrackUploaded;
use App\User;
use Eureka\Services\Interfaces\ArtistContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Webpatser\Uuid\Uuid;

class UploadTrack extends AppApiJobs implements ShouldQueue
{
    /**
     * @var
     */
    private $audioData;
    /**
     * @var User
     */
    private $artist;

    /**
     * Create a new job instance.
     *
     * @param $audioData
     * @param User $artist
     */
    public function __construct($audioData, User $artist)
    {
        $this->audioData = $audioData;
        $this->artist = $artist;
    }

    /**
     * Execute the job.
     *
     * @param ArtistContract $artistActivity
     * @throws \Exception
     */
    public function handle(ArtistContract $artistActivity)
    {
        $audioData = $this->prepareAudioData($this->audioData);

        try{
            $track = $artistActivity->uploadTrack($audioData, $this->artist);
            event(new TrackUploaded($track));
        }catch (\Exception $e){
            throw $e;
        }
    }

    protected function saveDataToSession()
    {
        session()->put('audioData', [
            'released_date' => $this->audioData->get('released_date'),
            'title' => $this->audioData->get('title'),
            'category_id' => $this->audioData->get('category_id')
        ]);
    }

    private function prepareAudioData($audioData)
    {
        $uuid = Uuid::generate(4);
        $audioData = array_add($audioData, "uuid", $uuid);
        return $audioData;
    }
}
