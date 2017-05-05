<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 2/28/2016
 * Time: 2:37 PM
 */

namespace Eureka\Helpers\Transformers\Mobile;


use App\Ad;
use App\AdSection;
use App\Stream;
use App\Track;
use App\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class MobileTrackCollectionTransformer extends TransformerAbstract
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * @param Track $track
     * @return array
     */
    public function transform(Track $track){
        return [
            "title" => $track->title,
            "artist_name" => $track->author->stage_name,
            "released_date" => Carbon::parse($track->released_date)->timestamp * 1000,
            "downloads" => $track->usersWhoDownloaded->count(),
            "likes" => $track->usersWhoLiked->count(),
            "streams" => $track->streams->count(),
            "comments" => $track->comments->count(),
            "artistId" => $track->author->uuid,
            "uuid" => $track->uuid,
            "cover" => "http://192.168.74.1:8000" . $track->cover->path,
            "path" => "http://192.168.74.1:8000" . $track->file->path,
            "trackExt" => $track->file->extension,
            "coverExt" => $track->cover->extension,
            "duration" => $track->length,
            "downloadable" => (boolean)$track->downloadable,
            "downloaded" => $this->downloaded($track),
            "amTheOwner" => $this->amITheOwner($track),
            "liked" => $this->liked($track),
            "firstAd" => $this->getAudioAd($track),
            "secondAd" => null,
        ];
    }

    /**
     * @param Track $track
     * @return bool
     */
    private function downloaded(Track $track)
    {
        $user = $track->usersWhoDownloaded->where("user_id", (string)$this->user->id)->first();
        if($user != null){
            return true;
        }
        return false;
    }

    /**
     * @param Track $track
     * @return bool
     */
    private function amITheOwner(Track $track)
    {
        if($track->author->uuid == $this->user->uuid){
            return true;
        }
        return false;
    }

    /**
     * @param Track $track
     * @return bool
     */
    private function liked(Track $track)
    {
        if($track->usersWhoLiked->where("user_id", (string)$this->user->id)->first() != null){
            return true;
        }
        return false;
    }

    /**
     * @param $track
     * @return array|null
     */
    private function getAudioAd(Track $track)
    {
        $now = Carbon::now();
        $track_category_id = $track->category->id;
                //The current section based on the current time
        $section = AdSection::with('audio_ads', 'audio_ads.streams', 'audio_ads.categories')
            ->where('start_time', '<=', $now)->where('end_time', '>', $now)
            ->first();
        if(!$section) return null;
        $ad = collect($section->audio_ads)->where('is_section_active', '1')
                //Only the audio ads attached to the track category
            ->filter(function(Ad $ad) use($track_category_id){
            return !collect($ad->categories)->where('id', $track_category_id)->isEmpty();
                //Sort des based on the section attached audio ads streams
        })->sortByDesc(function(Ad $ad) use($section){
                //Only Streams that are happening currently
            return $ad->streams->filter(function(Stream $stream) use($section){
                return $section->start_time <= $stream->created_ad
                && $section->end_time > $stream->created_at;
            })->count();
                //Select the last audio ad because she has the least streams
        })->last();
        if(!$ad) return null;
        return ['uuid'=>$ad->uuid, 'path'=>$ad->file->path];
    }


}