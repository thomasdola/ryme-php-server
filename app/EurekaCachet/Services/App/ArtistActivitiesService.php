<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/21/2016
 * Time: 12:09 PM
 */

namespace Eureka\Services\App;


use App\Photo;
use App\Track;
use App\User;
use DB;
use Eureka\Services\Interfaces\ArtistContract;
use Eureka\Services\Interfaces\string;
use Exception;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

class ArtistActivitiesService implements ArtistContract
{
    private $artist;

    /**
     *
     */
    public function __construct()
    {
        $this->artist = Auth::user();
    }

    /**
     * @param array $audioData
     * @param User $artist
     * @return mixed
     * @throws Exception
     */
    public function uploadTrack(array $audioData, User $artist)
    {
        //save track info to our local database
        DB::beginTransaction();
        $track = $artist->uploadedTracks()->create($audioData);
        if(!$track){
            DB::rollBack();
            $this->throwIExcp("Unable to store track", 404);
        }
        $file = $track->file()->create([
            'uuid' => Uuid::generate(4),
            'path' => collect($audioData)->get('track_full_path'),
            'extension' => collect($audioData)->get("track_ext")
        ]);
        if(!$file){
            DB::rollBack();
            $this->throwIExcp("Unable to store track file", 404);
        }
        $cover = $track->cover()->create([
            'path' => collect($audioData)->get("cover_full_path"),
            'type' => 'cover',
            'uuid' => Uuid::generate(4),
            'extension' => collect($audioData)->get("cover_ext")
        ]);
        if(!$cover){
            DB::rollBack();
            $this->throwIExcp("Unable to store track cover", 404);
        }
        DB::commit();
        return $track;
    }

    /**
     * @param $data
     * @param User $artist
     * @return mixed
     * @throws Exception
     */
    public function updateBackgroundPhoto($data, User $artist)
    {
        $result = null;
        $photo = $artist->photos->where('type', 'background')->first();
        if($photo){
            $result = $photo->update(['path'=>collect($data)->get('path')]);
        }else{
            $result = $artist->photos()->save(
                new Photo(['path'=>collect($data)->get('path'),
                    'type'=>'background', 'uuid'=>Uuid::generate(4),
                    'extension' => collect($data)->get('extension')])
            );
        }
        if(!$result){
            $this->throwIExcp("Could not save image", 404);
        }
    }


    /**
     * @param string $name
     * @param User $artist
     * @return bool
     * @throws Exception
     */
    public function updateStageName($name, User $artist)
    {
        if(!$artist->update(["stage_name"=>$name])){
            $this->throwIExcp("Could not save artist stage name.", 404);
        }
        return true;
    }

    /**
     * @param $message
     * @param $code
     * @throws Exception
     */
    private function throwIExcp($message, $code)
    {
        throw new Exception($message, $code);
    }

    /**
     * @param Track $track
     * @param $downloadable
     * @return mixed
     */
    public function updateTrackDownloadable(Track $track, $downloadable)
    {
        if(!$track->update(["downloadable"=>$downloadable])){
            $this->throwIExcp("Could not update track.", 404);
        }
        return true;
    }
}