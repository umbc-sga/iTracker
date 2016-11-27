<?php

namespace App\Classes\Basecamp;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class InvalidRequest extends \Exception{
}

class BasecampAPI
{
    protected $accessToken = null;
    protected $baseUri = null;

    public function __construct($base_uri, $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->baseUri = $base_uri;
    }

    public function get($resource, $force = false){
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        $resource = ltrim($resource,'/');

        if(env('BASECAMP_API_CACHING', true) && !$force && ($cached = cache($resource)))
            return json_decode($cached);

        $res = $client->request('GET', $resource, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'User-Agent' => env('BASECAMP_AGENT')
            ]
        ]);

        $json = $res->getBody()->getContents();

        if(env('BASECAMP_API_CACHING', true) && $res->getStatusCode() == 200)
            cache([$resource => $json], env('BASECAMP_API_CACHING', 60));

        return json_decode($json);
    }

    public function projects(){
        $resp = $this->get('projects.json');

        return collect($resp)->filter(function($project){
            return strtolower($project->purpose) == 'topic';
        });
    }

    public function project($id){
        return $this->get('projects/'.$id.'.json');
    }
    public function peopleInProject($id){
        return $this->get('projects/'.$id.'people.json');
    }

    public function teams(){
        return collect($this->get('projects.json'))->filter(function($value, $key){
            return strtolower($value->purpose) == 'team';
        });
    }

    public function people(){
        return $this->get('people.json');
    }
    public function person($id){
        return $this->get('people/'.$id.'.json');
    }
}