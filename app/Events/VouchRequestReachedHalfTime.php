<?php

namespace App\Events;

use App\Events\Event;
use App\Vouch;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VouchRequestReachedHalfTime extends Event
{
    use SerializesModels;
    /**
     * @var Vouch
     */
    public $vouch;

    /**
     * Create a new event instance.
     *
     * @param Vouch $vouch
     */
    public function __construct(Vouch $vouch)
    {
        //
        $this->vouch = $vouch;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
