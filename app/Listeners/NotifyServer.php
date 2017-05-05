<?php

namespace App\Listeners;

use App\Events\VouchRequestSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyServer
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
     * @param  VouchRequestSent  $event
     * @return void
     */
    public function handle(VouchRequestSent $event)
    {
        //
    }
}
