<?php

namespace App\Events;

use App\Vouch;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class VouchRequestSent extends Event implements ShouldBroadcast
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
