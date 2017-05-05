<?php

namespace App\Jobs;

use App\Events\VouchRequestSent;
use App\Jobs\Job;
use App\User;
use Eureka\Services\Interfaces\NotificationServiceInterface;
use Eureka\Services\Interfaces\VouchServiceInterface;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mockery\Exception;

class MakeVouchRequest extends AppApiJobs implements ShouldQueue
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var
     */
    private $token;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param User $user
     * @param $token
     */
    public function __construct(array $data, User $user, $token)
    {
        $this->data = $data;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @param VouchServiceInterface $vouchService
     * @param NotificationServiceInterface $notificationService
     * @throws \Exception
     */
    public function handle(VouchServiceInterface $vouchService, NotificationServiceInterface $notificationService)
    {
        try{
            $vouch = $vouchService->makeRequest($this->user);
            $notificationService->subscribe($this->token, $vouch->channel->uuid);
            $this->updateUser();
            event(new VouchRequestSent($vouch));
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    private function updateUser()
    {
        $data = array_add($this->data, "is_request_active", true);
        $job = new UpdateProfileInfo($data, $this->user);
        try{
            $this->dispatch($job);
        }catch (\Exception $e){
            throw $e;
        }
    }
}
