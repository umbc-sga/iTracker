<?php

namespace App\Classes\Basecamp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;


class BasecampAPI
{
    /**
     * API Access token
     * @var string
     */
    protected $accessToken = null;

    /**
     * Base API URL
     * @var string
     */
    protected $baseUri = null;

    /**
     * API Options
     * @var array
     */
    private $options = [];

    /**
     * @var Collection
     */
    private $restrictedEmails = null;

    /**
     * BasecampAPI constructor.
     * @param $base_uri string Base basecamp API url
     * @param $accessToken string Access token to use
     */
    public function __construct($base_uri, $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->baseUri = $base_uri;
        $this->options = [
            'cacheEnabled' => config('services.basecamp.cachingEnabled'),
            'cacheDecayTime' => config('services.basecamp.cacheAgeOff')
        ];

        $this->restrictedEmails = collect([]);
    }

    /**
     * Is caching enabled?
     * @return bool
     */
    protected function cacheEnabled(){ return $this->options['cacheEnabled']; }

    /**
     * How long should the cache live for? (in minutes)
     * @return int
     */
    protected function cacheDecayTime(){ return $this->options['cacheDecayTime']; }

    /**
     * Set people to be filtered out of site
     * @param array $emails
     */
    public function setEmailFilters($emails = []){ $this->restrictedEmails = collect($emails); }

    /**
     * Should person be filtered?
     * @param $person object Basecamp Person Object
     * @return bool
     */
    protected function filteredPerson($person){
        return $this->restrictedEmails->search($person->email_address) === false;
    }
    /**
     * Get request to API
     * @param $resource string Resource URL
     * @param $force bool Force API call, ignore setting
     * @return object
     */
    public function get($resource, $force = false){
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        //Trim left slashes
        $resource = ltrim($resource,'/');

        $cacheName = 'apicall-'.$resource;

        //If caching enabled and not forced, return cached response
        if($this->cacheEnabled() && !$force && ($cached = cache($cacheName)))
            return json_decode($cached);

        //Cache miss call to API
        //@todo handle exceptions
        $res = $client->request('GET', $resource, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'User-Agent' => env('BASECAMP_AGENT')
            ]
        ]);

        //Get JSON payload
        $json = $res->getBody()->getContents();

        //Cache this if it's a 200 response
        if($this->cacheEnabled() && $res->getStatusCode() == 200)
            cache([$cacheName => $json], $this->cacheDecayTime());

        return json_decode($json);
    }


    /**
     * Get array of all projects
     * @param bool $stripTeamHash From project list, strip out all team hashing
     * @return Collection
     */
    public function projects($stripTeamHash = true){
        $cacheName = 'api-projects'.$stripTeamHash;

        //Check cache
        if($cached = cache($cacheName))
            return collect($cached);

        //Miss, call to API
        $resp = $this->get('projects.json');

        //Filter out anything that is not a 'project'
        $projects = collect($resp)->filter(function($project){
            return strtolower($project->purpose) == 'topic';
        })->transform(function($project) use ($stripTeamHash){
            unset($project->dock);

            if($stripTeamHash && ($str = $this->getTeamString($project->description)))
                $project->description = str_replace($str, '', $project->description);

            return $project;
        })->values();

        //Cache
        cache([$cacheName => $projects->jsonSerialize()], $this->cacheDecayTime());

        return $projects;
    }

    /**
     * Get basecamp project
     * @param $id int Project ID
     * @return object
     */
    public function project($id){
        $cacheName = 'api-project-'.$id;

        //Check cache
        if($cached = cache($cacheName))
            return json_decode($cached);

        $project = $this->get('projects/'.$id.'.json');

        unset($project->dock);

        $project->people = $this->peopleInProject($project->id);

        if($str = $this->getTeamString($project->description))
            $project->description = str_replace($str, '', $project->description);

        cache([$cacheName => json_encode($project)], $this->cacheDecayTime());

        return $this->get('projects/'.$id.'.json');
    }

    /**
     * Get all people in project
     * @param $id int Project ID
     * @return Collection
     */
    public function peopleInProject($id){
        return collect($this->get('projects/'.$id.'/people.json'))->filter(function($person){
            return $this->filteredPerson($person);
        })->values();
    }

    /**
     * Get all teams
     * @return Collection
     */
    public function teams(){
        $cacheName = 'api-teams';

        //Check cache
        if($cached = cache($cacheName))
            return collect($cached);

        //Filter anything not a 'team'
        $teams = collect($this->get('projects.json'))->filter(function($team){
            return strtolower($team->purpose) == 'team';
        })->transform(function($team) {
            unset($team->dock);
            return $team;
        })->values();

        //Cache
        cache([$cacheName => $teams->jsonSerialize()], $this->cacheDecayTime());
        return $teams;
    }

    /**
     * Get team by ID
     * @param $id int Team ID
     * @return object
     */
    public function team($id){
        $cacheName = 'api-team-'.$id;

        //Check cache
        if($cached = cache($cacheName))
            return json_decode($cached);

        $team = $this->project($id);

        unset($team->dock);
        //Add additional fields
        $team->projects = $this->teamProjects($team->id);
        $team->memberships = $this->peopleInProject($team->id);

        //Cache
        cache([$cacheName => json_encode($team)], $this->cacheDecayTime());

        return $team;
    }

    /**
     * Get team by name
     * @param $name string Team name
     * @return object
     */
    public function teamByName($name){
        $cacheName = 'api-team-'.$name;

        //Check cache for ID
        if($cached = cache($cacheName))
            return json_decode($cached);

        //Go through all teams until it's found
        $team = $this->teams()->filter(function($team) use ($name){
            return $name == preg_replace('/&/', 'and', preg_replace('/\\s/', '-', strtolower($team->name)));
        });

        $team = $team->count() > 0 ? $team->first() : null;

        if(is_null($team))
            return null;

        //Add additional fields
        $team->projects = $this->teamProjects($team->id);
        $team->memberships = $this->peopleInProject($team->id);

        //Cache
        cache([$cacheName => json_encode($team)], $this->cacheDecayTime());

        return $team;
    }

    private function getTeamString($str){
        $matches = [];
        if(preg_match_all('/#teams(?: (\d+))+/', $str, $matches) > 0)
            return $matches[0][0];

        return null;
    }

    /**
     * Get all team projects
     * @param $dept int Department ID
     * @return Collection
     */
    public function teamProjects($dept){
        $cacheName = 'api-team-projects-'.$dept;

        if($cached = cache($cacheName))
            return collect($cached);

        //Go through all projects until API is found
        $teamProjects = $this->projects(false)->filter(function($project) use ($dept){
            if(is_null($project->description)) return false;

            if($str = $this->getTeamString($project->description)) {
                $matches = [];

                preg_match_all('/([0-9]+)/', $str, $matches);
                $project->description = str_replace($str, '', $project->description);

                return in_array($dept, collect($matches)->splice(1)->last());
            }

            return false;
        })->values();

        //Cache
        cache([$cacheName => $teamProjects->jsonSerialize()], $this->cacheDecayTime());

        return $teamProjects;
    }


    /**
     * Get all people
     * @return Collection
     */
    public function people(){
        return collect($this->get('people.json'))->filter(function($person){
            return $this->filteredPerson($person);
        })->values();
    }

    /**
     * Get person
     * @param $id int Person iD
     * @return object
     */
    public function person($id){
        return $this->get('people/'.$id.'.json');
    }
}