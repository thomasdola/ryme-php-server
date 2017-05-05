<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateProfilePicture extends AppApiJobs implements ShouldQueue
{
    /**
     * @var
     */
    private $photoData;

    /**
     * Create a new job instance.
     *
     * @param $photoData
     * @param User $user
     */
    public function __construct($photoData, User $user)
    {
        $this->user = $user;
        $this->photoData = $photoData;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     * @throws \Exception
     */
    public function handle(UserContract $userActivity)
    {
        try{
            $userActivity->updateProfilePicture($this->photoData, $this->user);
        }catch (\Exception $e){
            throw $e;
        }
    }
}
