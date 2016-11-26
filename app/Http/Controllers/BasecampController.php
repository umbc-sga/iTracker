<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use League\OAuth2\Client\Provider\GenericProvider;


class BasecampController extends Controller
{
    public function endpoint(Request $request){
        $client = new GenericProvider([
            'clientId' => config('services.basecamp.id'),
            'clientSecret' => config('services.basecamp.secret'),
            'redirectUri' => route('bcEndpoint'),
            'urlAuthorize' => config('services.basecamp.authUrl'),
            'urlAccessToken' => config('services.basecamp.tokenUrl').'?type=web_server',
            'urlResourceOwnerDetails' => '',
        ]);

        $token = $client->getAccessToken('authorization_code', ['code' => $request->input('code', '')]);

        Cache::forever('BCaccessToken', $token->getToken());
        Cache::forever('BCrefreshToken', $token->getRefreshToken());
        Cache::forever('BCexpiration', $token->getExpires());

        return redirect()->intended();
    }

    public function projects(){
        return ['projects'];
    }

    public function people(){
        return ['people'];
    }
}
