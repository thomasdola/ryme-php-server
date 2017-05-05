<?php

namespace App\Listeners;

use App\Events\UserJoined;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserGraph
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
     * @param  UserJoined  $event
     * @return void
     */
    public function handle(UserJoined $event)
    {
        //
    }
}
