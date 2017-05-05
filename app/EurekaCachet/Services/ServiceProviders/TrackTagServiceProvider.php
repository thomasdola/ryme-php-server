<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 10:00 AM
 */

namespace Eureka\Services\ServiceProviders;


use Eureka\Services\Internal\TrackTagService;
use Illuminate\Support\ServiceProvider;

class TrackTagServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Eureka\Services\Interfaces\TrackTagServiceInterface', function($app){
            return new TrackTagService();
        });
    }
}