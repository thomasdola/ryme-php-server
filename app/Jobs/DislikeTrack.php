<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Track;
use App\User;
use Eureka\Services\Interfaces\UserContract;
use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DislikeTrack extends AppApiJobs implements ShouldQueue
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
     * @throws Exception
     */
    public function __construct(Track $track, User $user)
    {
        $this->track = $track;
        try{
            $this->user = $user;
        }catch (Exception $e){
            throw $e;
        }
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     */
    public function handle(UserContract $userActivity)
    {
        $userActivity->dislikeTrack($this->track, $this->user);
    }
}
