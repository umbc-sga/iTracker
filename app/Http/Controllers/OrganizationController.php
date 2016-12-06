<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationUser;
use App\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Does person in organization have permission?
     * @param User $user user to check
     * @param Organization $org Organization
     * @param $name array|string Array or string of permissions to check
     * @return bool
     */
    protected function getOrganizationPermission(User $user, Organization $org, $name){
        if($user->email == env('APP_SUPER_ADMIN')) return true;

        $permissions = OrganizationUser::where('user_id', $user->id)
            ->where('organization_id', $org->id)
            ->with('role', 'role.permissions')
            ->first()
            ->role
            ->permissions
            ->pluck('permission');

        if(!is_array($name))
            $name = [$name];

        foreach($name as $test)
            if($permissions->search($test))
                return true;

        return false;
    }
}
