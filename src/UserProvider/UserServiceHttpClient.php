<?php

namespace S25\Auth\UserProvider;

use GuzzleHttp\Client;

class UserServiceHttpClient
{
    /** @var Client */
    private $httpClient;

  /** @var string */
  private $apiUrl;

  /** @var string */
  private $apiKey;

    public function __construct(Client $client)
    {
        $this->httpClient = $client;
        $this->apiUrl = rtrim(config('through.auth_service'), '/');
        $this->apiKey = config('through.api_key', '');
    }

    public function getById(string $uid)
    {
        $response = $this->httpClient->get(
            sprintf('%s/api/user/%s', $this->apiUrl, $uid),
            [
              'headers' => [
                'X-API-KEY' => $this->apiKey,
              ]
            ]
        );

        return $response->getBody()->getContents();
    }

    public function all(?string $projectCode)
    {
        $query = null;

        if ($projectCode) {
            $query = ['project' => $projectCode];
        }

        $response = $this->httpClient->get(
            sprintf('%s/api/users', $this->apiUrl),
            [
                'query' => $query,
                'headers' => [
                  'X-API-KEY' => $this->apiKey,
                ]
            ]
        );

        return $response->getBody()->getContents();
    }
}
