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

    /**
     * API OAuth Endpoint
     * @param Request $request
     * @param BasecampClient $bc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function endpoint(Request $request, BasecampClient $bc){
        //If there was an error, retry
        if($request->input('error', null))
            return redirect()->route('home');

        //Get the token
        $token = $bc->web()->getAccessToken('authorization_code', ['code' => $request->input('code', '')]);

        //Store all into the cache
        Cache::forever('BCaccessToken', $token->getToken());
        Cache::forever('BCrefreshToken', $token->getRefreshToken());
        Cache::forever('BCexpiration', $token->getExpires());

        //Redirect where they intended to go
        return redirect()->intended();
    }

    /**
     * Invalid API request
     * @param Request $request
     * @param $msg string Message to append to error
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function invalid(Request $request, $msg = null){
        return response()->json([
            'message' => 'Invalid API request'.$msg ? ': '.$msg : ''
        ])->setStatusCode(400);
    }

    /**
     * Get all projects
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function projects(Request $request){
        return $this->api->projects();
    }

    /**
     * Get single project
     * @param Request $request
     * @param $project int Project ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function project(Request $request, $project){
        return response()->json($this->api->project($project));
    }

    /**
     * Get all people in a project
     * @param Request $request
     * @param $project int Project ID
     * @return \Illuminate\Support\Collection
     */
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

    /**
     * Get all groups
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function groups(Request $request){
        return $this->api->teams();
    }

    /**
     * Get single group
     * @param Request $request
     * @param $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function group(Request $request, $group){
        return response()->json($this->api->team($group));
    }

    /**
     * Get department by name
     * @param Request $request
     * @param $deptName string Name of department
     * @return \Illuminate\Http\JsonResponse
     */
    public function dept(Request $request, $deptName){
        return response()->json($this->api->teamByName($deptName));
    }

    /**
     * Get department projects
     * @param Request $request
     * @param $dept int Department ID
     * @return \Illuminate\Support\Collection
     */
    public function deptartmentProjects(Request $request, $dept){
        return $this->api->teamProjects($this->api->teamByName($dept)->id);
    }

    /**
     * Get all people
     * @return \Illuminate\Support\Collection
     */
    public function people(){
        return $this->api->people();
    }

    //@todo handle todos
    public function todos(Request $request, $status=null){
        if(!in_array($status, ['active', 'completed', null]))
            return $this->invalid($request, 'No valid todo status');

        return ['todos'];
        //return $this->api->get('')
    }
}
