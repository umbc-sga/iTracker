<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use App\Classes\Basecamp\BasecampClient;


class Basecamp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Resolve the basecamp client out of the container
        $bc = resolve(BasecampClient::class);

        //If access token is expired or hit the refresh lottery get a new token
        if(Cache::get('BCexpiration', 0) < time() || rand(0,100) > 90) {
            if ($refreshToken = cache('BCrefreshToken')) {
                $token = $bc->refresh()->getAccessToken('refresh_token', [
                    'refresh_token' => $refreshToken
                ]);

                Cache::forever('BCaccessToken', $token->getToken());
                Cache::forever('BCexpiration', $token->getExpires());
            } else {
                if (is_null($request->input('code', null))) {
                    $request->session()->put('url.intended', url()->current());

                    return redirect()->to($bc->web()->getAuthorizationUrl() . '&type=web_server');
                }
            }
        }

        return $next($request);
    }
}
