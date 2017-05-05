<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Track;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DownloadTrack extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Track
     */
    private $track;

    /**
     * Create a new job instance.
     *
     * @param Track $track
     */
    public function __construct(Track $track)
    {
        //
        $this->track = $track;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     */
    public function handle(UserContract $userActivity)
    {
        $userActivity->downloadTrack($this->track);
    }
}
