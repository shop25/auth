<?php

namespace S25\Auth\UserProvider;


use Illuminate\Cache\Repository;
use S25\Auth\User;

class CachedUserProvider implements UserProviderInterface
{
    /** @var UserProviderInterface */
    private $userRepository;

    /** @var Repository */
    private $cache;

    public function __construct(HttpUserRepository $userRepository, Repository $cache)
    {
        $this->userRepository = $userRepository;
        $this->cache = $cache;
    }

    public function getByUid(string $uid): ?User
    {
        $cacheKey = sprintf('user_%s', $uid);
        $user = $this->cache->get($cacheKey);

        if ($user === null) {
            $user = $this->userRepository->getByUid($uid);
            $this->cache->set($cacheKey, $user, config('session.lifetime') * 60);
        }

        return $user;
    }

    public function all(?string $projectCode): array
    {
        $cacheKey = sprintf('users::%s', $projectCode);
        $users = $this->cache->get($cacheKey);

        if ($users === null) {
            $users = $this->userRepository->all($projectCode);
            $this->cache->set($cacheKey, $users, config('session.lifetime') * 60);
        }

        return $users;
    }
}
