<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Classes\Basecamp\BasecampAPI;
use App\Classes\Basecamp\BasecampClient;

//@todo FILTER THESE EMAILS OUT OF USERS: 'sga@umbc.edu','berger@umbc.edu','saddison@umbc.edu'
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

    //@todo Migrate to API class
    public function projectEvents(Request $request, $project, $page = 1){
        $project = $this->api->project($project);

        $schedule = collect($project->dock)->filter(function($dock){ return $dock->name == 'schedule'; })->first();
        return $this->api->get(rtrim($schedule->url, '.json').'/entries.json?page='.$page);
    }

    //@todo aggregate all relevant personal info
    // Include all projects and departments
    public function person(Request $request, $person){
        return response()->json($this->api->person($person));
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
        $department = $this->api->teamByName($dept);

        $department->projects = $this->api->teamProjects($department->id);
        $department->memberships = $this->api->peopleInProject($department->id);

        return response()->json($department);
    }

    public function deptartmentProjects(Request $request, $dept){
        $deptId = $this->api->teamByName($dept)->id;

        $deptId = $this->getDept($request, $dept)->id;

        return $this->api->projects()->filter(function($project) use ($deptId){
            if(is_null($project->description)) return false;

            $matches = [];
            if(preg_match_all('/#teams(?: (\d+))+/', $project->description, $matches) > 0)
                preg_match_all('/([0-9]+)/', $matches[0][0], $matches);
            else
                return false;

           return collect(collect($matches)->splice(1)->last())->search($deptId);
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
