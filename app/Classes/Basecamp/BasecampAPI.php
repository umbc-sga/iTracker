<?php

namespace App\Classes\Basecamp;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

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

        if(($cached = cache($resource)) && !$force){
            $arr = json_decode($cached);
            return $arr;
        }

        $res = $client->request('GET', $resource, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->accessToken,
                'User-Agent' => env('BASECAMP_AGENT')
            ]
        ]);

        $json = $res->getBody()->getContents();
        cache([$resource => $json], Carbon::now()->addHour(1));
        return json_decode($json);
    }
}