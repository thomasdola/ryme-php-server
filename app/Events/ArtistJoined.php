<?php

namespace App\Events;

use App\User;
use App\Vouch;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ArtistJoined extends Event implements ShouldBroadcast
{
    use SerializesModels;
    /**
     * @var User
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
