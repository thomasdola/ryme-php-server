<?php

namespace App\Events;

use App\Events\Event;
use App\VouchResponse;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VouchWasAnswered extends Event
{
    use SerializesModels;
    /**
     * @var VouchResponse
     */
    public $response;

    /**
     * Create a new event instance.
     * @param VouchResponse $response
     */
    public function __construct(VouchResponse $response)
    {
        //
        $this->response = $response;
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
