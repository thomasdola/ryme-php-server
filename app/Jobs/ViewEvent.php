<?php

namespace App\Jobs;

use App\Event;
use App\Jobs\Job;
use App\User;
use Eureka\Services\Interfaces\UserContract;
use Exception;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewEvent extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Event
     */
    private $eventAd;

    /**
     * Create a new job instance.
     *
     * @param Event $eventAd
     * @param User $user
     */
    public function __construct(Event $eventAd, User $user)
    {
        $this->eventAd = $eventAd;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     * @throws Exception
     */
    public function handle(UserContract $userActivity)
    {
        try{
            $userActivity->viewEvent($this->eventAd, $this->user);
        }catch (Exception $e){
            throw $e;
        }
    }
}
