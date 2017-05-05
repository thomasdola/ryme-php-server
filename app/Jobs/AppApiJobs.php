<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 9:56 PM
 */

namespace App\Jobs;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppApiJobs extends Job
{
    use Helpers, InteractsWithQueue, SerializesModels, DispatchesJobs;
}