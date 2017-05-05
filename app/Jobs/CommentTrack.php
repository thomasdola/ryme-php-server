<?php

namespace App\Jobs;

use App\Events\TrackCommented;
use App\Jobs\Job;
use App\Track;
use App\User;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class CommentTrack
 * @package App\Jobs
 */
class CommentTrack extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Track
     */
    private $track;
    /**
     * @var string|string
     */
    private $body;

    /**
     * Create a new job instance.
     *
     * @param Track $track
     * @param $body
     * @param User $user
     */
    public function __construct(Track $track, $body, User $user)
    {
        $this->track = $track;
        $this->body = $body;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     * @return mixed
     * @throws \Exception
     */
    public function handle(UserContract $userActivity)
    {
        try{
            $comment = $userActivity->commentTrack($this->track, $this->body, $this->user);
            \Event::fire('track.commented', $comment);
            event(new TrackCommented($comment));
        }catch (\Exception $e){
            throw $e;
        }
    }
}
