<?php

namespace App\Http\Controllers;

use App\Classes\Basecamp\BasecampAPI;
use App\Organization;
use App\OrganizationUser;
use App\ProjectPicture;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends OrganizationController
{
    protected $api;

    /**
     * ProjectController constructor.
     * @param BasecampAPI $api
     */
    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
    }

    /**
     * Upload image and store it
     * @param Request $request
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function imageUpload(Request $request, $project){
        if($validator = Validator::make($request->all(), [
            'image' => 'required|file|image'
        ])->validate())
            return response([
                'json' => $validator
            ])->setStatusCode(400);

        if($project = $this->api->project($project)){
            if(count($project->departments) > 0) {
                $org = Organization::where('api_id', $project->departments[0])->first();

                if ($org && $this->getOrganizationPermission(auth()->user(), $org, ['makeExec', 'editOfficers'])) {
                    $folder = '/projects';
                    $name = collect(explode('/', $request->file('image')->store('public'.$folder)))->last();

                    if ($picture = ProjectPicture::where('api_id', $project->id)->first()) {
                        $picture->update(['src' => $folder.'/'.$name]);
                    }
                    else {
                        ProjectPicture::create(['src' => $folder.'/'.$name, 'api_id' => $project->id]);
                    }

                    return response()->json(true);
                }
            }
        }

        return response()->json(false);
    }
}
