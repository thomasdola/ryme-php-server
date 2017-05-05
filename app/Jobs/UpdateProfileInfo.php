<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProfileInfo extends AppApiJobs implements ShouldQueue
{
    /**
     * @var array
     */
    private $info;

    /**
     * Create a new job instance.
     *
     * @param array $info
     * @param User $user
     */
    public function __construct(array $info, User $user)
    {
        $this->info = $info;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     */
    public function handle(UserContract $userActivity)
    {
        $userActivity->updateProfileInfo($this->info, $this->user);
    }
}
