<?php

namespace App\Observers;

use App\Classes\Basecamp\BasecampAPI;
use App\Organization;

class OrganizationObserver
{
    protected $api = null;
    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
    }

    //@todo Setup organization
    public function created(Organization $organization){
        $people = $this->api->peopleInProject($organization->api_id);
    }
}