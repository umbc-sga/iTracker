<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use League\OAuth2\Client\Provider\GenericProvider;


class Basecamp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Cache::get('BCexpiration', 0) < time() || true)
            if(Cache::has('BCrefreshToken')){
                $client = new GenericProvider([
                    'clientId' => config('services.basecamp.id'),
                    'clientSecret' => config('services.basecamp.secret'),
                    'redirectUri' => route('bcEndpoint'),
                    'urlAuthorize' => config('services.basecamp.authUrl'),
                    'urlAccessToken' => config('services.basecamp.tokenUrl').'?type=refresh',
                    'urlResourceOwnerDetails' => '',
                ]);

                $token = $client->getAccessToken('refresh_token', [
                   'refresh_token' => Cache::get('BCrefreshToken')
                ]);

                Cache::forever('BCaccessToken', $token->getToken());
                Cache::forever('BCexpiration', $token->getExpires());
            }
            else {
                $client = new GenericProvider([
                    'clientId' => config('services.basecamp.id'),
                    'clientSecret' => config('services.basecamp.secret'),
                    'redirectUri' => route('bcEndpoint'),
                    'urlAuthorize' => config('services.basecamp.authUrl'),
                    'urlAccessToken' => config('services.basecamp.tokenUrl').'?type=web_server',
                    'urlResourceOwnerDetails' => '',
                ]);

                if(is_null($request->input('code', null))) {
                    $request->session()->put('url.intended', url()->current());

                    return redirect()->to($client->getAuthorizationUrl() . '&type=web_server');
                }
            }

        return $next($request);
    }
}
