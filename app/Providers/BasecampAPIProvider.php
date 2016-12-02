<?php

namespace App\Providers;

use App\Classes\Basecamp\BasecampAPI;
use App\Classes\Basecamp\BasecampClient;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class BasecampAPIProvider extends ServiceProvider
{

    /**
     * Bootstrap the api
     * @param Request $request
     * @param BasecampAPI $api
     */
    public function boot(Request $request, BasecampAPI $api)
    {
        $api->setRequest($request);
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
            return new BasecampAPI(config('services.basecamp.url'), cache('BCaccessToken'));
        });
    }
}
