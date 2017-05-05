<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/3/2016
 * Time: 5:34 PM
 */

namespace App\Jobs;


use App\Track;
use Eureka\Services\Interfaces\ArtistContract;
use Mockery\CountValidator\Exception;

class UpdateTrackInfo extends AppApiJobs
{
    /**
     * @var
     */
    private $data;
    /**
     * @var
     */
    private $track_id;

    /**
     * @param $track_id
     * @param $data
     */
    public function __construct($track_id, $data){
        $this->data = $data;
        $this->track_id = $track_id;
    }


    public function handle(ArtistContract $artistActivities)
    {
        try{
            $track = Track::where("uuid", $this->track_id)->first();
            $artistActivities->updateTrackDownloadable($track, $this->data);
        }catch (Exception $e){
            throw $e;
        }
    }
}