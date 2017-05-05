<?php

namespace App\Listeners;

use App\Events\ArtistJoined;
use App\User;
use App\Vouch;
use Carbon\Carbon;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyToBeArtistEndorsers
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
        $this->updateArtist($event->vouch->user());
        $event_type = snake_case("ArtistJoined");
        $channel = $event->vouch->user->channel->uuid;
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
        $artist_name = strtoupper($vouch->user->artist_name);
        return [
            'title' => $artist_name,
            'body' => "{$artist_name} just made on Ryme.",
            'artist_id'=>$vouch->user->uuid
        ];
    }

    /**
     * @param User $user
     */
    private function updateArtist(User $user)
    {
        $user->update([
            'is_artist' => true,
            'artist_on' => Carbon::now()
        ]);
    }
}
