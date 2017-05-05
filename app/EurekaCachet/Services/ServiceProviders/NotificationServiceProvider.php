<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 3/13/2016
 * Time: 7:35 AM
 */

namespace Eureka\Services\ServiceProviders;


use Eureka\Services\Internal\GoogleCloudMessagingService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Eureka\Services\Interfaces\NotificationServiceInterface', function($app){
            return new GoogleCloudMessagingService();
        });
    }
}