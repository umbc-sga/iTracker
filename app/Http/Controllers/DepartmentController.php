<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationRoles;
use App\OrganizationUser;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    protected function getOrganizationPermission(User $user, Organization $org,  $name){
        return $user->email == env('APP_SUPER_ADMIN')
            || false !== OrganizationUser::where('user_id', $user->id)
                    ->where('organization_id', $org->id)
                    ->with('role', 'role.permissions')
                    ->first()
                    ->role
                    ->permissions
                    ->pluck('permission')
                    ->search($name);
    }

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

    public function editProfile(Request $request, $dept){
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

        if($org && $this->getOrganizationPermission(auth()->user(), $org, 'updateMembersInfo')) {
            $user = OrganizationUser::where('user_id', $profile->user->id)
                ->where('organization_id', $org->id)->with('user', 'user.profile')->first();

            if($user->user->profile)
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
