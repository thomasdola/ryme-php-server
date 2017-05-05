<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/24/2016
 * Time: 10:36 AM
 */

namespace Eureka\Services\ServiceProviders;


use Dingo\Api\Routing\Helpers;
use Eureka\Services\App\VouchService;
use Illuminate\Support\ServiceProvider;

class VouchServiceProvider extends ServiceProvider
{
    use Helpers;
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Eureka\Services\Interfaces\VouchServiceInterface', function($app){
            return new VouchService($this->auth->user());
        });
    }
}