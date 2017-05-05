<?php

namespace App\Jobs;

use App\Category;
use App\Jobs\Job;
use App\User;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowGenre extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Category
     */
    private $genre;
    /**
     * @var
     */
    private $token;

    /**
     * Create a new job instance.
     *
     * @param Category $genre
     * @param User $user
     * @param $token
     */
    public function __construct(Category $genre, User $user, $token)
    {
        $this->genre = $genre;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     * @param NotificationServiceInterface $notificationService
     * @throws \Exception
     */
    public function handle(UserContract $userActivity, NotificationServiceInterface $notificationService)
    {
        try{
            $notificationService->subscribe($this->token, $this->genre->channel->uuid);
            $userActivity->followCategory($this->genre, $this->user);
        }catch (\Exception $e){
            throw $e;
        }
    }
}
