<?php

namespace App\Observers;

use App\Classes\Basecamp\BasecampAPI;
use App\Organization;
use App\OrganizationRoles;
use App\OrganizationUser;
use App\Profile;

class OrganizationObserver
{
    protected $api = null;
    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
    }

    public function created(Organization $organization){
        $people = $this->api->peopleInProject($organization->api_id);

        $profiles = Profile::whereIn('api_id', $people->pluck('id'))->with('user')->get();

        if($normie = OrganizationRoles::where('stub', 'peasant')->first())
            foreach($profiles as $profile)
                OrganizationUser::create([
                    'user_id' => $profile->user->id,
                    'organization_id' => $organization->id,
                    'organization_role' => $normie->id,
                    'title' => $normie->title
                ]);
    }
}