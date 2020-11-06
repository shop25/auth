<?php

namespace S25\Auth\UserProvider;

use GuzzleHttp\Client;

class UserServiceHttpClient
{
    /** @var Client */
    private $httpClient;

    /** @var string */
    private $apiUrl;

    public function __construct(Client $client)
    {
        $this->httpClient = $client;
        $this->apiUrl = config('through.auth_service');
    }

    public function getById(string $uid)
    {
        $response = $this->httpClient->get(
            sprintf('%s/api/user/%s', $this->apiUrl, $uid)
        );

        return $response->getBody()->getContents();
    }

    public function all()
    {
        $response = $this->httpClient->get(
            sprintf('%s/api/users', $this->apiUrl)
        );

        return $response->getBody()->getContents();
    }
}
