<?php

namespace App\Jobs;

use App\Events\VouchWasAnswered;
use App\Jobs\Job;
use App\User;
use App\Vouch;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerVouch extends AppApiJobs implements ShouldQueue
{
    /**
     * @var Vouch
     */
    private $vouchRequest;
    /**
     * @var boolean
     */
    private $answer;
    /**
     * @var
     */
    private $token;

    /**
     * Create a new job instance.
     *
     * @param Vouch $vouchRequest
     * @param $answer
     * @param User $user
     * @param $token
     */
    public function __construct(Vouch $vouchRequest, $answer, User $user, $token)
    {
        $this->vouchRequest = $vouchRequest;
        $this->answer = $answer;
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
            $vouchAnswer = $userActivity->answerVouch($this->vouchRequest,
                $this->answer, $this->user);
            if((boolean)$this->answer){
                $notificationService->subscribe($this->token, $this->vouchRequest->user->channel->uuid);
            }
            event(new VouchWasAnswered($vouchAnswer));
        }catch (\Exception $e){
            throw $e;
        }
    }
}
