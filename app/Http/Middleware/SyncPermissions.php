<?php

namespace App\Http\Middleware;

use App\Classes\Basecamp\BasecampAPI;
use Closure;

class SyncPermissions
{
    protected $api;

    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cacheName = 'api-permission_check'.auth()->id();
        //If guess or cached check
        if(!auth()->guest() && !cache($cacheName))
            if($result = auth()->user()->syncPermissions($this->api))
                cache([$cacheName => true], config('services.basecamp.cacheAgeOff'));

        return $next($request);
    }
}
