<?php

namespace App\Jobs;

use App\User;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Eureka\Services\Interfaces\UserContract;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnfollowArtist extends AppApiJobs implements ShouldQueue
{
    /**
     * @var User
     */
    private $artist;
    /**
     * @var
     */
    private $token;

    /**
     * Create a new job instance.
     *
     * @param User $artist
     * @param User $user
     * @param $token
     */
    public function __construct(User $artist, User $user, $token)
    {
        $this->artist = $artist;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     * @param NotificationServiceInterface $notificationService
     * @throws Exception
     */
    public function handle(UserContract $userActivity, NotificationServiceInterface $notificationService)
    {
        try{
            $notificationService->unsubscribe($this->token, $this->user->channel->uuid);
            $userActivity->unFollowArtist($this->artist, $this->user);
        }catch (Exception $e){
            throw $e;
        }
    }
}
