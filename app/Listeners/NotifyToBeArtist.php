<?php

namespace App\Listeners;

use App\Events\ArtistJoined;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyToBeArtist
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
     * @param  ArtistJoined $event
     * @throws \Exception
     */
    public function handle(ArtistJoined $event)
    {
        $event_type = snake_case("ArtistJoined");
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
        $total_yes = $vouch->responses->where('answer', '1')->count();
        $total_no = $vouch->responses->where('answer', '0')->count();
        $artist_name = strtoupper($vouch->user->artist_name);
        return [
            'title' => "Congrats! {$artist_name}",
            'body' => "You successfully made it as a Musician on Ryme with {$total_yes} yes(es) and {$total_no} no(s).",
            'artist_id' => $vouch->user->uuid
        ];
    }
}
