<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/19/2016
 * Time: 3:14 PM
 */

namespace Eureka\Repositories;


use App\AdSection;
use App\Category;
use App\Event;
use App\Following;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class EventAdRepository
 * @package Eureka\Repositories
 */
class EventAdRepository
{
    /**
     * @var Event
     */
    private $event;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param Event $event
     * @param UserRepository $userRepository
     */
    public function __construct(Event $event, UserRepository $userRepository){
        $this->event = $event;
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        $events = $this->event->all();
        return $events;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSingle($id)
    {
        $event = $this->event->where('uuid', $id)->first();
        return $event;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $event = $this->getSingle($id);
        $event = $event->fill($data);
        $event->save();
        return $event;
    }

    /**
     * @param $data
     * @return static
     */
    public function addEvent($data)
    {
        $event = $this->event->create($data);
        return $event;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $event = $this->getSingle($id);
        $event->delete();
        return $event;
    }

    /**
     * @return mixed
     */
    public function getAds()
    {
        $activeAds = $this->event->where('is_active', '1')->get();
        return $activeAds;
    }

    /**
     * @param User $user
     */
    public function getAdsScopedTo(User $user)
    {
        $categories = $this->userRepository->followedCategories($user);
    }

    /**
     * @param User $user
     * @return static
     */
    public function getRelevantEventAdsFor(User $user)
    {
        $now = Carbon::now();
        $categories = $this->getCategoryIdsFor($user);
        //The current section based on the current time
        $section = AdSection::with('event_ads', 'event_ads.categories')
            ->where('start_time', '<=', $now)->where('end_time', '>', $now)
            ->first();
//        $section = AdSection::first();
        if(!$section) return [];
        return collect($section->event_ads)->where('is_section_active', '1')
            ->filter(function(Event $event) use($categories){
                $event_categories = $this->getIds($event->categories);
                if(!collect($event_categories)->intersect($categories)->isEmpty()){
                    return true;
                }else{
                    return false;
                }
            })->shuffle();
    }

    /**
     * @param User $user
     * @return array
     */
    private function getCategoryIdsFor(User $user)
    {
        $ids = collect([]);
        collect($user->followings->where("followable_type", 'App\Category')->all())
            ->each(function($category) use($ids){
                $ids->push($category->followable_id);
            });
        return $ids->unique();
    }

    /**
     * @param $categories
     * @return static
     */
    private function getIds($categories)
    {
        $ids = collect([]);
        collect($categories)->each(function($category) use($ids){
            $ids->push($category->id);
        });
        return $ids->unique();
    }
}