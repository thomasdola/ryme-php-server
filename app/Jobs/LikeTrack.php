<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Track;
use App\User;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mockery\CountValidator\Exception;

class LikeTrack extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Track
     */
    private $track;

    /**
     * Create a new job instance.
     *
     * @param Track $track
     * @param User $user
     */
    public function __construct(Track $track, User $user)
    {
        $this->track = $track;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     */
    public function handle(UserContract $userActivity)
    {
        try{
            $userActivity->likeTrack($this->track, $this->user);
        }catch (Exception $e){
            throw $e;
        }
    }
}
