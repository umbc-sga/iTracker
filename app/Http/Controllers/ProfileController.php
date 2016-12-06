<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

use App\Profile;

class ProfileController extends Controller
{
    /**
     * Edit profile
     * @param Request $request
     * @return array
     */
    public function edit(Request $request){
        $this->validate($request, [
            'profile' => 'required|numeric',
            'bio' => 'required|string',
            'classStanding' => 'required|in:freshman,sophomore,junior,senior,graduate,staff',
            'major' => 'required|string',
            'hometown' => 'required|string',
            'fact' => 'required|string'
        ]);

        if(auth()->user()->profile->api_id == $request->input('profile', null))
            Profile::where('api_id', $request->input('profile'))->update([
                'biography' => $request->input('bio', null),
                'classStanding' => $request->input('classStanding', null),
                'major' => $request->input('major', null),
                'hometown' => $request->input('hometown', null),
                'fact' => $request->input('fact', null),
            ]);

        return ['redirectTo' => '/people/'.$request->input('profile')];
    }

    /**
     * @param Request $request
     * @param $person int Person API
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request, $person){
        if($profile = Profile::where('api_id', $person)->first())
            return $profile;
        else
            return response([
                'error' => 'No profile found'
            ])->setStatusCode(404);
    }
}
