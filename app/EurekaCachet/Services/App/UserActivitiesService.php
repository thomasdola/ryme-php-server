<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/21/2016
 * Time: 12:09 PM
 */

namespace Eureka\Services\App;


use App\Category;
use App\Event;
use App\Following;
use App\Photo;
use App\Track;
use App\User;
use App\Vouch;
use Eureka\Services\Interfaces\UserContract;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Webpatser\Uuid\Uuid;

/**
 * Class UserActivitiesService
 * @package Eureka\Services\App
 */
class UserActivitiesService implements UserContract
{

    /**
     * A user favorites a Track
     *
     * @param Track $track
     * @param User $user
     * @return mixed|void
     */
    public function likeTrack(Track $track, User $user)
    {
        $user->likedTracks()->attach([$track->id]);
    }

    /**
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function dislikeTrack(Track $track, User $user)
    {
        $user->likedTracks()->detach([$track->id]);
    }

    /**
     * A user streams a track
     *
     * @param Track $track
     * @param User $user
     * @return mixed|void
     */
    public function streamTrack(Track $track, User $user)
    {
        $track->streams()->create([
            'user_id'=>$user->id
        ]);
    }

    /**
     * A user comment on a track
     *
     * @param Track $track
     * @param $commentBody
     * @param User $user
     * @return mixed|void
     */
    public function commentTrack(Track $track, $commentBody, User $user)
    {
        $comment = $track->comments()->create([
            'user_id'=>$user->id,
            'body'=>$commentBody
        ]);
        if(! $comment){
            $this->throwIExcp("Unable to comment on track.", 404);
        }
        return $comment;
    }

    /**
     * A user downloads a track
     *
     * @param Track $track
     * @param User $user
     * @return mixed|void
     */
    public function downloadTrack(Track $track, User $user)
    {
        $user->downloadedTracks()->attach($track->id);
    }

    /**
     * A user follows an artist
     *
     * @param User $artist
     * @param User $user
     * @return mixed|void
     */
    public function followArtist(User $artist, User $user)
    {
        $following = $artist->followers()->create([
            'user_id'=>$user->id
        ]);
        if(!$following){
            $this->throwIExcp("could not follow artist", 404);
        }
        return $following;
    }

    /**
     * A user unFollows artist
     *
     * @param User $artist
     * @param User $user
     * @return mixed
     */
    public function unFollowArtist(User $artist, User $user)
    {
        //We first need to update the GCM store

        $deleted = Following::where([
            'user_id'=>$user->id,
            'followable_id'=>$artist->id,
            'followable_type'=>'App\User'])->delete();

        if(!$deleted){
            $this->throwIExcp("could not unfollow artist", 404);
        }
        return $deleted;
    }

    /**
     * @param Category $category
     * @param User $user
     * @return mixed|void
     */
    public function followCategory(Category $category, User $user)
    {
        //We first need to update the GCM store

        $category = $category->followers()->create([
            'user_id'=>$user->id
        ]);
        if($category == null){
            $this->throwIExcp("Could not follow category", 404);
        }
    }

    /**
     * A user can follow many categories simultaneously
     *
     * @param array $categoryIds
     * @param User $user
     * @return mixed
     */
    public function followManyCategories(array $categoryIds, User $user)
    {
        $payload = $this->getPayload($categoryIds);
        $user->followings()->createMany($payload->all());
    }

    /**
     * A user unFollow a category
     * @param Category $category
     * @param User $user
     * @return mixed|void
     */
    public function unFollowCategory(Category $category, User $user)
    {
        $deleted = Following::where([
            'user_id'=>$user->id,
            'followable_id'=>$category->id,
            'followable_type'=>'App\Category'])->delete();
        if(!$deleted){
            $this->throwIExcp("Could Not unfollow Category", 404);
        }
    }

    /**
     * A user views (clicks) a track
     *
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function viewTrack(Track $track, User $user)
    {
        $track->views()->create([
            'user_id'=>$user->id
        ]);
    }

    /**
     * A user views (clicks) an event for more detail
     *
     * @param Event $event
     * @param User $user
     * @return mixed
     */
    public function viewEvent(Event $event, User $user)
    {
        $view = $event->views()->create([
            'user_id'=>$user->id
        ]);
        if(! $view) $this->throwIExcp("could not lod view", 404);
    }

    /**
     * A user vouches for a user to be artist (answer could be either true or false)
     *
     * @param Vouch $vouch
     * @param $answer
     * @param User $user
     * @return mixed
     */
    public function answerVouch(Vouch $vouch, $answer, User $user)
    {
        $vouch =  $vouch->responses()->create([
            'answer'=>(boolean)$answer,
            'user_id'=>$user->id
        ]);
        if(!$vouch){
            $this->throwIExcp("Could not answer the vouch", 404);
        }
        return $vouch;
    }

    /**
     * @param $data
     * @param User $user
     * @return mixed|void
     * @throws Exception
     */
    public function updateProfilePicture($data, User $user)
    {
        $result = null;
        $photo = $user->photos->where('type', 'avatar')->first();
        if($photo){
            $result = $photo->update(['path'=>collect($data)->get('path')]);
        }else{
            $result = $user->photos()->save(
                new Photo(['path'=>collect($data)->get('path'),
                    'type'=>'avatar', 'uuid'=>Uuid::generate(4),
                    'extension' => collect($data)->get('extension')])
            );
        }
        if(!$result){
            $this->throwIExcp("Could not save image", 404);
        }
    }

    /**
     * @param array $data
     * @param User $user
     * @return mixed
     * @throws Exception
     */
    public function updateProfileInfo(array $data, User $user)
    {
        if(!$user->update($data)){
            $this->throwIExcp("Could not update user information.", 404);
        }
        return true;
    }

    /**
     * @param array $categoryIds
     * @return \Illuminate\Support\Collection
     */
    private function getPayload(array $categoryIds)
    {
        $payload = collect([]);
        foreach ($categoryIds as $id) {
            $payload->push(['followable_id' => $id, 'followable_type' => 'App\Category']);
        }
        return $payload;
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
}