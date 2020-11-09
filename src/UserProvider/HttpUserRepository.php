<?php

namespace S25\Auth\UserProvider;


use S25\Auth\User;

class HttpUserRepository implements UserProviderInterface
{
    /** @var UserServiceHttpClient */
    private $userClient;

    public function __construct(UserServiceHttpClient $userClient)
    {
        $this->userClient = $userClient;
    }

    public function getByUid(string $uid): ?User
    {
        $response = $this->userClient->getById($uid);
        $userData = json_decode($response, true);

        if ($userData['user']) {
            return new User($userData['user']);
        }

        return null;
    }

    public function all(?string $projectCode): array
    {
        $response = $this->userClient->all($projectCode);
        $userData = json_decode($response, true);

        $users = [];

        if ($userData['users']) {
            foreach ($userData['users'] as $user) {
                $users[] = new User($user);
            }
        }

        return $users;
    }
}
