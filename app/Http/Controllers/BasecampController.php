<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Classes\Basecamp\BasecampAPI;
use App\Classes\Basecamp\BasecampClient;


class BasecampController extends Controller
{
    public function endpoint(Request $request, BasecampClient $bc){
        $token = $bc->web()->getAccessToken('authorization_code', ['code' => $request->input('code', '')]);

        Cache::forever('BCaccessToken', $token->getToken());
        Cache::forever('BCrefreshToken', $token->getRefreshToken());
        Cache::forever('BCexpiration', $token->getExpires());

        return redirect()->intended();
    }

    public function projects(Request $request, BasecampAPI $api){
        return $api->get('projects.json');
    }

    public function people(){
        return ['people'];
    }
}
