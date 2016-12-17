<?php

namespace App\Providers;

use App\Observers\OrganizationObserver;
use App\Organization;
use Illuminate\Support\ServiceProvider;

class OrganizationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Organization::observe(OrganizationObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
