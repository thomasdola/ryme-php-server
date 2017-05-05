<?php

namespace Eureka\Services\App;


use App\NotificationChannel;
use App\User;
use App\Vouch;
use Carbon\Carbon;
use DB;
use Eureka\Services\Interfaces\VouchServiceInterface;
use Webpatser\Uuid\Uuid;

/**
 * Class VouchService
 * @package Eureka\Services\App
 */
class VouchService implements VouchServiceInterface
{
    /**
     * @param User $user
     * @return mixed|void
     * @throws \Exception
     */
    public function makeRequest(User $user)
    {
        //Throw an exception if the user is not allowed to make a new request
        if( ! $this->isAllowed($user) ){
            throw new \Exception('Not Allowed to make a new Vouch Request', 401);
        }
        DB::beginTransaction();
        $vouchRequest = $this->activateRequest($user);
        $channel = $this->createChannel($vouchRequest, $user);
        $this->subscribeUserToChannel($channel);
        DB::commit();
        return $vouchRequest;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isAllowed(User $user)
    {
        if($user->is_artist) return false;
        $numberOfRequest = $user->vouchRequests->count();
        if( $numberOfRequest !== 0 ){
            $request = $user->vouchRequests->last();
            $monthsElapsed = $this->getMonthsElapsed($request);

            if( $monthsElapsed < 3 ){
                //User Cannot make a new request
                return false;
            }
            //User can make a new request
            return true;
        }
        //User can make a new request
        return true;
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    protected function activateRequest(User $user)
    {
        return $user->vouchRequests()->create([
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addWeeks(2),
            'is_active' => true,
            'uuid'=>Uuid::generate()
        ]);
    }

    /**
     * @param Vouch $vouchRequest
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    private function createChannel(Vouch $vouchRequest, User $user)
    {
        return $vouchRequest->channel()->create([
            'name'=>$user->stage_name.'VouchRequest',
            'uuid'=>Uuid::generate()
        ]);
    }

    /**
     * @param NotificationChannel $channel
     */
    private function subscribeUserToChannel(NotificationChannel $channel)
    {
        //Subscribe user to Vouch Request Channel on GCM
    }

    /**
     * @param $request
     * @return int
     */
    private function getMonthsElapsed($request)
    {
        $time = $this->carbonize($request->end_date);
        $today = Carbon::now();
        $diffInMonths = $today->diffInMonths($time);
        return $diffInMonths;
    }

    /**
     * @param $timestamp
     * @return static
     */
    private function carbonize($timestamp)
    {
        return Carbon::parse($timestamp);
    }
}