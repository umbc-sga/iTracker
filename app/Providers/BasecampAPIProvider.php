<?php

namespace App\Providers;

use App\Classes\Basecamp\BasecampAPI;
use App\Classes\Basecamp\BasecampClient;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class BasecampAPIProvider extends ServiceProvider
{
    /**
     * Bootstrap the api
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
        //Register basecamp API service
        $this->app->singleton(BasecampAPI::class, function($app){
            return new BasecampAPI();
        });
    }
}
