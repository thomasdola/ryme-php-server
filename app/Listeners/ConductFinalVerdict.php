<?php

namespace App\Listeners;

use App\Events\ArtistJoined;
use App\Events\UserCouldNotMakeId;
use App\Events\VouchRequestWasDue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConductFinalVerdict
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VouchRequestWasDue  $event
     * @return void
     */
    public function handle(VouchRequestWasDue $event)
    {
        $this->updateUser($event);
        $total_yes = $event->vouch->responses->where('answer', '1')->count();
        if($total_yes >= 100){
            event(new ArtistJoined($event->vouch));
        }else{
            event(new UserCouldNotMakeId($event->vouch));
        }
    }

    /**
     * @param VouchRequestWasDue $event
     */
    private function updateUser(VouchRequestWasDue $event)
    {
        $event->vouch->user()->update(['is_request_active'=>false]);
    }
}
