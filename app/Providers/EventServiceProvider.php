<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserJoined' => [
            'App\Listeners\UpdateUserGraph',
        ],
        'App\Events\VouchRequestSent' => [
            'App\Listeners\NotifyServer',
        ],
        'App\Events\VouchWasAnswered' => [
            'App\Listeners\NotifyRequestSender'
        ],
        'App\Events\VouchRequestReachedHalfTime' => [
            'App\Listeners\NotifyRequestSenderForSoFarReport'
        ],
        'App\Events\VouchRequestWasDue' => [
            'App\Listeners\ConductFinalVerdict'
        ],
        'App\Events\UserCouldNotMakeId' => [
            'App\Listeners\NotifyLooserUser'
        ],
        'App\Events\ArtistJoined' => [
            'App\Listeners\UpdateArtistGraph',
            'App\Listeners\NotifyToBeArtist',
            'App\Listeners\NotifyToBeArtistEndorsers',
        ],
        'App\Events\TrackUploaded' => [
            'App\Listeners\NotifyArtistFollowersOfNewTrack',
        ],
        'App\Events\UserCreated' => [
            'App\Listeners\SendOtp'
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
