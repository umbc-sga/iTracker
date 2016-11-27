<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Classes\Basecamp\BasecampAPI;
use App\Classes\Basecamp\BasecampClient;


class BasecampController extends Controller
{
    /**
     * @var BasecampAPI
     */
    protected $api;

    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
    }

    public function endpoint(Request $request, BasecampClient $bc){
        if($request->input('error', null))
            return redirect()->route('home');

        $token = $bc->web()->getAccessToken('authorization_code', ['code' => $request->input('code', '')]);

        Cache::forever('BCaccessToken', $token->getToken());
        Cache::forever('BCrefreshToken', $token->getRefreshToken());
        Cache::forever('BCexpiration', $token->getExpires());

        return redirect()->intended();
    }

    public function invalid(Request $request, $msg){
        return response()->json([
            'message' => 'Invalid API request: '.$msg
        ])->setStatusCode(400);
    }

    public function projects(Request $request){
        return $this->api->projects();
    }

    public function project(Request $request, $project){
        return response()->json($this->api->project($project));
    }

    public function peopleInProject(Request $request, $project){
        return $this->api->peopleInProject($project);
    }

    public function projectEvents(Request $request, $project, $page = 1){
        $project = $this->api->project($project);

        $schedule = collect($project->dock)->filter(function($dock){ return $dock->name == 'schedule'; })->first();
        return $this->api->get(rtrim($schedule->url, '.json').'/entries.json?page='.$page);
    }

    public function personProject(Request $request, $person){
        return null;
    }

    //@todo aggregate all relevant personal info
    // Include all projects and departments
    public function person(Request $request, $person){
        $perp = $this->api->person($person);
        $perp->projects = [];
        return response()->json($perp);
    }

    public function groups(Request $request){
        return $this->api->teams();
    }

    public function group(Request $request, $group){
        return $this->project($request, $group);
    }

    public function getDept(Request $request, $dept){
        $groups = $this->groups($request);

        $groups = $groups->filter(function($group) use ($dept){
            $convertedName = preg_replace('/&/', 'and', preg_replace('/\\s/', '-', strtolower($group->name)));
            return $convertedName == $dept;
        });

        return $groups->count() > 0 ? $groups->first() : null;
    }

    public function dept(Request $request, $dept){
        $ret = $this->getDept($request, $dept);
        $ret->memberships = $this->api->peopleInProject($ret->id);
        $ret->projects = $this->deptProjects($request, $dept);

        return response()->json($ret);
    }

    public function deptProjects(Request $request, $dept){
        $deptId = $this->getDept($request, $dept)->id;

        $peopleInDept = $this->api->peopleInProject($deptId);

        return $this->api->projects()->filter(function($project) use($peopleInDept){
            $people = $this->api->peopleInProject($project->id)->pluck('id');

            foreach($peopleInDept as $person)
                return $people->search($person->id) !== false;

            return false;
        })->values();
    }

    public function people(){
        return $this->api->people();
    }

    public function todos(Request $request, $status=null){
        if(!in_array($status, ['active', 'completed', null]))
            return $this->invalid($request, 'No valid todo status');

        return ['todos'];
        //return $this->api->get('')
    }
}
