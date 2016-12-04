<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Classes\Basecamp\BasecampAPI;
use App\Classes\Basecamp\BasecampClient;
use Illuminate\Support\Facades\Validator;

class BasecampController extends Controller
{
    /**
     * @var BasecampAPI
     */
    protected $api;

    private $filteredEmails = [
        'sga@umbc.edu',
        'berger@umbc.edu',
        'saddison@umbc.edu'
    ];

    public function __construct(BasecampAPI $api)
    {
        $this->api = $api;
        $this->api->setEmailFilters($this->filteredEmails);
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

    // Include all projects and departments
    public function person(Request $request, $person){
        $apiPerson = $this->api->person($person);

        if(!is_null($apiPerson) && property_exists($apiPerson, 'id')) {
            $apiPerson->profile = Profile::where('api_id', $apiPerson->id)->with('user')->first();
            if($apiPerson->profile)
                $apiPerson->user = User::fullUser($apiPerson->profile->user->id);
        }

        return response()->json($apiPerson);
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
    public function dept(Request $request, $deptName)
    {
        $department = $this->api->teamByName($deptName);
        $ids = collect($department->memberships)->pluck('id');
        $profiles = Profile::whereIn('api_id', $ids)
            ->with('user',
                'user.organizations',
                'user.organizations.organization',
                'user.organizations.role')
            ->get();

        foreach ($profiles as $profile)
            foreach ($profile->user->organizations as $organization)
                if ($organization->organization->api_id == $department->id) {
                    $person = &$department->memberships[$ids->search($profile->api_id)];
                    $person->position = $organization->title;
                    $person->role = $organization->role;
                }

        return response()->json($department);
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

    /**
     * Get project Todos
     * @param Request $request
     * @param $project object Project object
     * @return \Illuminate\Http\JsonResponse
     */
    public function todos(Request $request, $project){
        return response()->json($this->api->projectTodos($this->api->project($project)));
    }

    /**
     * Get history of project
     * @param Request $request
     * @param $project object Project object
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request, $project){
        return response()->json($this->api->projectHistory($this->api->project($project)));
    }

    /**
     * Invite person to basecamp project
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(Request $request){
        if(!config('services.basecamp.openAccess'))
            return redirect()->route('home')->with('message', 'Sorry, you can\'t join projects');

        $input = $request->all();
        $input['email'] = auth()->user()->email;

        $validator = Validator::make($input, [
            'projectID' => 'required|numeric',
            'email' => 'required|email'
        ])->validate();

        if(!$validator && ends_with(auth()->user()->email, '@umbc.edu'))
            $this->api->inviteOrGrant($request->input('projectID'), auth()->user()->email);

        return redirect()->route('home')->with('message', 'If you don\'t already have access check your email to join!');
    }
}
