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

    /**
     * Login using google driver
     * @return mixed
     */
    public function login(){
        return Socialite::driver('google')->redirect();
    }

    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        auth()->logout();
        return redirect()->route('home');
    }

    /**
     * OAuth callback
     * @param Request $request
     * @param BasecampAPI $api
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request, BasecampAPI $api){
        //Get google user
        $user = Socialite::driver('google')->user();

        //Store google user into session
        $request->session()->put('google_user', $user);

        //Get user account
        $usr = User::where('email', $user->email)->first();

        if(!$usr) {
            $usr = User::firstOrCreate([
                'google_id' => $user->id,
                'google_etag' => $user->user['etag'],
                'google_token' => $user->token,
                'display_name' => $user->user['displayName'],
                'email' => $user->email,
                'name' => $user->name,
            ]);
        }

        //Log user in
        auth()->login($usr, true);

        //Generate profile
        if($profile = $usr->generateProfile($api))
            return redirect()->route('profile.edit', ['user' => $profile->api_id]);

        return redirect()->intended();
    }
}