<?php

namespace App\Listeners;

use App\Events\ArtistCouldNotMakeId;
use App\Events\UserCouldNotMakeId;
use App\Vouch;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyLooserUser
{
    /**
     * @var NotificationServiceInterface
     */
    private $notificationService;

    /**
     * Create the event listener.
     * @param NotificationServiceInterface $notificationService
     */
    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param  UserCouldNotMakeId $event
     * @throws \Exception
     */
    public function handle(UserCouldNotMakeId $event)
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

    /**
     * @param Vouch $vouch
     * @return array
     */
    private function makeMessage(Vouch $vouch)
    {
        $artist_name = strtoupper($vouch->user->name);
        $total_yes = $vouch->responses->where('answer', '1')->count();
        $total_no = $vouch->responses->where('answer', '0')->count();
        return [
            'title'=>"Sorry, {$artist_name}.",
            'body'=>"You could not make it as a musician on Ryme. Yes: {$total_yes}, No: {$total_no}"
        ];
    }
}
