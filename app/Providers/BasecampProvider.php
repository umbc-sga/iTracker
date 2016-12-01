<?php

namespace App\Providers;

use App\Classes\Basecamp\BasecampClient;
use Illuminate\Support\ServiceProvider;


class BasecampProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Register OAuth client for basecamp
        $this->app->singleton(BasecampClient::class, function($app){
            return new BasecampClient(config('services.basecamp'), route('auth.bcEndpoint'));
        });
    }
}
