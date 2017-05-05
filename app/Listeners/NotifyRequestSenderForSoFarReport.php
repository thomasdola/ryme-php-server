<?php

namespace App\Listeners;

use App\Events\VouchRequestReachedHalfTime;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyRequestSenderForSoFarReport
{
    /**
     * @var NotificationServiceInterface
     */
    private $notificationService;

    /**
     * Create the event listener.
     *
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(NotificationServiceInterface $notificationService)
    {
        //
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  VouchRequestReachedHalfTime $event
     * @throws \Exception
     */
    public function handle(VouchRequestReachedHalfTime $event)
    {
        $event_type = snake_case("UserCouldNotMakeId");
        $channel = $event->vouch->channel->uuid;
        $message = $this->makeMessage($event->vouch);
        try{
            $this->notificationService->publish($channel, $message, $event_type);
        }catch (\Exception $e){
            throw $e;
        }
    }

    private function makeMessage($vouch)
    {
        $artist_name = strtoupper($vouch->user->name);
        $total_yes = $vouch->responses->where('answer', '1')->count();
        $total_no = $vouch->responses->where('answer', '0')->count();
        return [
            'title'=>"Hi {$artist_name}",
            'body'=>"Last 7 days Report on Your Request. Yes: {$total_yes}, No: {$total_no}"
        ];
    }
}
