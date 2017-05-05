<?php

namespace App\Events;

use App\Events\Event;
use App\Track;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TrackUploaded extends Event
{
    use SerializesModels;
    /**
     * @var Track
     */
    public $track;

    /**
     * Create a new event instance.
     *
     * @param Track $track
     */
    public function __construct(Track $track)
    {
        $this->track = $track;
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
