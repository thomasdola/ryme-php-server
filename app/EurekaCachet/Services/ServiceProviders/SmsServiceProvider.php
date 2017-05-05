<?php

namespace Eureka\Services\ServiceProviders;

use Eureka\ThirdPartyServices\SmsApi;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Eureka\Services\Interfaces\SmsApiInterface', function($app){
            return new SmsApi();
        });
    }
}
