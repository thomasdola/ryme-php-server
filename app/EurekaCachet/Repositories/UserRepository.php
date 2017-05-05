<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/8/2016
 * Time: 8:16 PM
 */

namespace Eureka\Repositories;


use App\Category;
use App\User;
use Carbon\Carbon;

/**
 * Class UserRepository
 * @package Eureka\Repositories
 */
class UserRepository
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

    public function getUserByUsername($username){
        return $this->user->where('username', $username)->first();
    }

    /**
     * @param User $user
     * @return array
     */
    public function followedCategories(User $user){
        $categories = collect([]);
        $ids =  $user->followingCategories->where('followable_type', 'App\Category')->all();
        if(!collect($ids)->isEmpty()){
            foreach ($ids as $id) {
                $categories->push(Category::find($id->followable_id));
            }
        }
        return $categories->all();
    }
    /**
     * @return int
     */
    public function getAllUsersCount()
    {
       return $this->getAllUsers()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllUsers()
    {
        return $this->user->all();
    }

    /**
     * @return mixed
     */
    public function getUsersJoinedTodayCount()
    {
        return $this->getUsersJoinedToday()->count();
    }

    /**
     * @return mixed
     */
    public function getUsersJoinedToday()
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        return $this->getRecentJoinedUsers($startDate, $endDate);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    private function getRecentJoinedUsers($startDate, $endDate)
    {
        return $this->user->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getUsersJoinedThisWeekCount()
    {
        return $this->getUsersJoinedThisWeek()->count();
    }

    /**
     * @return mixed
     */
    public function getUsersJoinedThisWeek()
    {
        $startDate = Carbon::now()->subWeek()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        return $this->getRecentJoinedUsers($startDate, $endDate);
    }

    /**
     * @return mixed
     */
    public function getUsersJoinedThisMonthCount()
    {
       return $this->getUsersJoinedThisMonth()->count();
    }

    /**
     * @return mixed
     */
    public function getUsersJoinedThisMonth()
    {
        $startDate = Carbon::now()->subMonth()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        return $this->getRecentJoinedUsers($startDate, $endDate);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id)
    {
        $deletedUser = $this->user->find($id);
        $deletedUser->delete();
        return $deletedUser;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getFavoriteTracksFor(User $user)
    {
        return $user->likedTracks->unique();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getFavoriteArtistsFor(User $user)
    {
        return $user->followings->where("followable_type", 'App\User')
            ->map(function($following){
                return $this->user->find($following->followable_id);
            })->unique()->all();
    }

    /**
     * @param array $data
     * @param $userId
     * @return mixed
     */
    public function update(array $data, $userId)
    {
        $user = $this->user->where('uuid', $userId)->first();
        $user = $user->fill($data);
        $user->save();
        return $user;
    }

    /**
     * @param array $data
     * @return static
     */
    public function add(array $data)
    {
        return $this->user->create($data);
    }

    public function updateStatus($id)
    {
        $user = $this->getUserById($id);
        $user->update(['status'=>true]);
    }

    /**
     * @param $id
     */
    private function getUserById($id)
    {
        return $this->user->where('uuid', $id)->first();
    }

    public function isAllowed($uuid)
    {
        $user = $this->user->where("uuid", $uuid)->first();
        $date_joined = Carbon::parse($user->created_at);
        if($date_joined->addWeek()->lt(Carbon::today())){
            return false;
        }
        return true;
    }

    public function findUserByName($name, $withRequestOn)
    {
        return $this->user->where('stage_name', 'like', "%{$name}%")
            ->where(function($query) use ($withRequestOn){
                $query->where('is_request_active', $withRequestOn);
            })
            ->get();
    }
}