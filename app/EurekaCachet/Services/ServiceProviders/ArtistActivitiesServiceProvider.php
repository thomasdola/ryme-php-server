<?php
/**
 * Created by PhpStorm.
 * User: GURU
 * Date: 1/23/2016
 * Time: 1:07 PM
 */

namespace Eureka\Services\ServiceProviders;


use Eureka\Services\App\ArtistActivitiesService;
use Illuminate\Support\ServiceProvider;

class ArtistActivitiesServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Eureka\Services\Interfaces\ArtistContract', function($app){
            return new ArtistActivitiesService();
        });
    }
}