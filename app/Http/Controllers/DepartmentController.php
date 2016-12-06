<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationRoles;
use App\OrganizationUser;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends OrganizationController
{
    /**
     * Make person in department an executive cabinet member
     * @param Request $request
     * @param $dept int Department ID
     * @param $person int Person ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeExec(Request $request, $dept, $person){
        $profile = Profile::where('api_id', $person)->with('user')->first();

        if(!$profile)
            return response(['error' => 'No account exists'])->setStatusCode(400);

        $org = Organization::where('api_id', $dept)->first();
        $roles = OrganizationRoles::all()->keyBy('stub');

        if($org && $this->getOrganizationPermission(auth()->user(), $org, 'makeExec')) {
            $user = OrganizationUser::where('user_id', $profile->user->id)
                ->where('organization_id', $org->id)->first();

            if($user->organization_role == $roles['exec']->id)
                $user->update(['organization_role' => $roles['peasant']->id]);
            else
                $user->update(['organization_role' => $roles['exec']->id]);

            return response()->json(true);
        }

        return response()->json(false);
    }

    /**
     * Make person in department a cabinet member
     * @param Request $request
     * @param $dept int Department ID
     * @param $person int Person ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeCabinet(Request $request, $dept, $person){
        $profile = Profile::where('api_id', $person)->with('user')->first();

        if(!$profile)
            return response(['error' => 'No account exists'])->setStatusCode(400);

        $org = Organization::where('api_id', $dept)->first();
        $roles = OrganizationRoles::all()->keyBy('stub');

        if($org && $this->getOrganizationPermission(auth()->user(), $org, 'editOfficers')) {
            $user = OrganizationUser::where('user_id', $profile->user->id)
                ->where('organization_id', $org->id)->first();

            if($user->organization_role == $roles['cabinet']->id)
                $user->update(['organization_role' => $roles['peasant']->id]);
            else
                $user->update(['organization_role' => $roles['cabinet']->id]);

            return response()->json(true);
        }

        return response()->json(false);
    }

    /**
     * Edit profile information of someone in department
     * @param Request $request
     * @param $dept int Department ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function editProfile(Request $request, $dept){
        //Validate profile information
        if($validator = Validator::make($request->all(), [
            'profile' => 'required|numeric',
            'bio' => 'required|string',
            'classStanding' => 'required|in:freshman,sophomore,junior,senior,graduate,staff',
            'major' => 'required|string',
            'hometown' => 'required|string',
            'fact' => 'required|string'
        ])->validate())
            return response(['json' => $validator])->setStatusCode(400);

        $profile = Profile::where('api_id', $request->input('profile', 'null'))->with('user')->first();

        if(!$profile)
            return response(['error' => 'No account exists'])->setStatusCode(400);

        $org = Organization::where('api_id', $dept)->first();

        //Check whether authed user can edit profile
        if($org && $this->getOrganizationPermission(auth()->user(), $org, 'updateMembersInfo')) {
            //See if person is in the organization at all
            $user = OrganizationUser::where('user_id', $profile->user->id)
                ->where('organization_id', $org->id)->with('user', 'user.profile')->first();

            //If user has profile
            if($user->user->profile)
                //Update it
                $user->user->profile->update([
                    'biography' => $request->input('bio', null),
                    'classStanding' => $request->input('classStanding', null),
                    'major' => $request->input('major', null),
                    'hometown' => $request->input('hometown', null),
                    'fact' => $request->input('fact', null),
                ]);

            return response()->json(true);
        }

        return response()->json(false);
    }
}
