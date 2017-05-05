<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Eureka\Services\Interfaces\UserContract;
use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowArtist extends AppApiJobs implements ShouldQueue
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
            $notificationService->subscribe($this->token, $this->user->channel->uuid);
            $userActivity->followArtist($this->artist, $this->user);
        }catch (Exception $e){
            throw $e;
        }
    }
}
