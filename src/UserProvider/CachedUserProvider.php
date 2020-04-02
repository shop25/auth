<?php

namespace S25\Auth\UserProvider;


use Illuminate\Cache\Repository;
use S25\Auth\User;

class CachedUserProvider implements UserProviderInterface
{
    private const TTL = 60 * 60; //one hour

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
            $this->cache->set($cacheKey, $user, self::TTL);
        }

        return $user;
    }
}
