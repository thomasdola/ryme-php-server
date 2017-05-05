<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 4:17 PM
 */

namespace Eureka\Services\ServiceProviders;


use Dingo\Api\Routing\Helpers;
use Eureka\Services\App\UserActivitiesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class UserActivitiesServiceProvider extends ServiceProvider
{
    use Helpers;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Eureka\Services\Interfaces\UserContract', function($app){
            return new UserActivitiesService();
        });
    }
}