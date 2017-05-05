<?php

namespace App\Listeners;

use App\Events\TrackUploaded;
use App\Track;
use Carbon\Carbon;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyArtistFollowersOfNewTrack
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
     * @param  TrackUploaded $event
     * @throws Exception
     */
    public function handle(TrackUploaded $event)
    {
        if($this->isReleasedToday($event->track)){
            $event_type = snake_case("TrackUploaded");
            $channel = $event->track->author->channel->uuid;
            $message = $this->makeMessage($event->track);
            try{
                $this->notificationService->publish($channel, $message, $event_type);
            }catch (Exception $e){
                throw $e;
            }
        }
    }

    /**
     * construct the mobile device notification message
     *
     * @param Track $track
     * @return array
     */
    private function makeMessage(Track $track)
    {
        $artist_name = strtoupper($track->author->artist_name);
        $track_title = strtoupper($track->title);
        return [
            'title' => "New Released on Ryme.",
            'body' => "{$track_title} by {$artist_name}",
            'track_id' => $track->uuid
        ];
    }

    /**
     * checks if the track date is today
     *
     * @param $track
     * @return bool
     */
    private function isReleasedToday($track)
    {
        return Carbon::parse($track->released_date)->eq(Carbon::today());
    }
}
