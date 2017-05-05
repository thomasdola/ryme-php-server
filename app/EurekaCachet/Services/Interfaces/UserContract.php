<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 7:57 AM
 */

namespace Eureka\Services\Interfaces;


use App\Category;
use App\Event;
use App\Track;
use App\User;
use App\Vouch;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface UserContract
 * @package Eureka\Services\Interfaces
 */
interface UserContract
{

    /**
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function likeTrack(Track $track, User $user);

    /**
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function dislikeTrack(Track $track, User $user);

    /**
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function streamTrack(Track $track, User $user);

    /**
     * @param Track $track
     * @param $commentBody
     * @param User $user
     * @return mixed
     */
    public function commentTrack(Track $track, $commentBody, User $user);

    /**
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function downloadTrack(Track $track, User $user);

    /**
     * @param User $artist
     * @param User $user
     * @return mixed
     */
    public function followArtist(User $artist, User $user);

    /**
     * @param User $artist
     * @param User $user
     * @return mixed
     */
    public function unFollowArtist(User $artist, User $user);

    /**
     * @param Category $category
     * @param User $user
     * @return mixed
     */
    public function followCategory(Category $category, User $user);

    /**
     * A user unFollow a category
     *
     * @param Category $category
     * @param User $user
     * @return mixed
     */
    public function unFollowCategory(Category $category, User $user);

    /**
     * A user can follow many categories simultaneously
     *
     * @param array $categoryIds
     * @param User $user
     * @return mixed
     */
    public function followManyCategories(array $categoryIds, User $user);

    /**
     * @param Vouch $vouch
     * @param $answer
     * @param User $user
     * @return mixed
     */
    public function answerVouch(Vouch $vouch, $answer, User $user);

    /**
     * @param Track $track
     * @param User $user
     * @return mixed
     */
    public function viewTrack(Track $track, User $user);

    /**
     * @param Event $event
     * @param User $user
     * @return mixed
     */
    public function viewEvent(Event $event, User $user);

    /**
     * @param  $photo
     * @param User $user
     * @return mixed
     */
    public function updateProfilePicture($photo, User $user);

    /**
     * @param array $data
     * @param User $user
     * @return mixed
     */
    public function updateProfileInfo(array $data, User $user);
}