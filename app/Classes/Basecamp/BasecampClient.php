<?php

namespace App\Classes\Basecamp;

use League\OAuth2\Client\Provider\GenericProvider;

class BasecampClient
{
    protected $clients = [];

    /**
     * BasecampClient constructor.
     * Construct two clients
     * @param $config
     * @param $endpoint
     */
    public function __construct($config, $endpoint)
    {
        $this->clients = [
            //Construct generic web request
            'web_server' => new GenericProvider([
                'clientId' => $config['id'],
                'clientSecret' => $config['secret'],
                'redirectUri' => $endpoint,
                'urlAuthorize' => $config['authUrl'],
                'urlAccessToken' => $config['tokenUrl'].'?type=web_server',
                'urlResourceOwnerDetails' => '',
            ]),
            //Construct refresh token client
            'refresh' => new GenericProvider([
                'clientId' => $config['id'],
                'clientSecret' => $config['secret'],
                'redirectUri' => $endpoint,
                'urlAuthorize' => $config['authUrl'],
                'urlAccessToken' => $config['tokenUrl'].'?type=refresh',
                'urlResourceOwnerDetails' => '',
            ])
        ];
    }

    /**
     * Get web client
     * @return GenericProvider
     */
    public function web(){
        return $this->clients['web_server'];
    }

    /**
     * Get refresh token client
     * @return GenericProvider
     */
    public function refresh(){
        return $this->clients['refresh'];
    }
}