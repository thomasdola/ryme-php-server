<?php

namespace App\Jobs;

use App\Jobs\Job;
use Eureka\Services\Interfaces\UserContract;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class followManyGenres extends Job implements ShouldQueue
{
    /**
     * @var array
     */
    private $categoryIds;

    /**
     * Create a new job instance.
     *
     * @param array $categoryIds
     */
    public function __construct(array $categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }

    /**
     * Execute the job.
     *
     * @param UserContract $userActivity
     */
    public function handle(UserContract $userActivity)
    {
        $userActivity->followManyCategories($this->categoryIds);
    }
}
