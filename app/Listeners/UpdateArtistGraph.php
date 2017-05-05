<?php

namespace App\Listeners;

use App\Events\ArtistJoined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateArtistGraph
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
     * @param  ArtistJoined  $event
     * @return void
     */
    public function handle(ArtistJoined $event)
    {
        //
    }
}
