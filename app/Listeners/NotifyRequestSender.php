<?php

namespace App\Listeners;

use App\Events\VouchWasAnswered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyRequestSender
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
     * @param  VouchWasAnswered  $event
     * @return void
     */
    public function handle(VouchWasAnswered $event)
    {
        //
    }
}
