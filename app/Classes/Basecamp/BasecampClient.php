<?php

namespace App\Classes\Basecamp;

use League\OAuth2\Client\Provider\GenericProvider;

class BasecampClient
{
    protected $clients = [];

    public function __construct($config, $endpoint)
    {
        $this->clients = [
            'web_server' => new GenericProvider([
                'clientId' => $config['id'],
                'clientSecret' => $config['secret'],
                'redirectUri' => $endpoint,
                'urlAuthorize' => $config['authUrl'],
                'urlAccessToken' => $config['tokenUrl'].'?type=web_server',
                'urlResourceOwnerDetails' => '',
            ]),
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
     * @return GenericProvider
     */
    public function web(){
        return $this->clients['web_server'];
    }

    /**
     * @return GenericProvider
     */
    public function refresh(){
        return $this->clients['refresh'];
    }
}