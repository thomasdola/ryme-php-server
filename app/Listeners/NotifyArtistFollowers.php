<?php

namespace App\Listeners;

use App\Events\TrackUploaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyArtistFollowers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TrackUploaded  $event
     * @return void
     */
    public function handle(TrackUploaded $event)
    {
        //
    }
}
