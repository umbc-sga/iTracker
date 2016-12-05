<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Basecamp\BasecampAPI;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

use App\User;

class AuthController extends Controller
{
    /**
     * AuthController constructor
     */
    public function __construct()
    {
        config()->set('services.google.redirect',route('auth.callback'));
    }

    public function login(){
        return Socialite::driver('google')->redirect();
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('home');
    }

    public function callback(Request $request, BasecampAPI $api){
        $user = Socialite::driver('google')->user();

        $request->session()->put('google_user', $user);

        $usr = User::where('email', $user->email)->first();

        if(!$usr) {
            $usr = User::firstOrCreate([
                'google_id' => $user->id,
                'google_etag' => $user->user['etag'],
                'google_token' => $user->token,
                'display_name' => $user->user['displayName'],
                'gender' => $user->user['gender'],
                'email' => $user->email,
                'name' => $user->name,
            ]);
        }

        auth()->login($usr, true);

        if($profile = $usr->generateProfile($api))
            return redirect()->route('profile.edit', ['user' => $profile->api_id]);

        return redirect()->intended();
    }
}