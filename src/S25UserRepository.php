<?php

namespace S25\Auth;


use Illuminate\Cache\RedisStore;
use Illuminate\Cache\Repository;
use Psr\SimpleCache\InvalidArgumentException;

class S25UserRepository implements UserRepositoryInterface
{
    /** @var Repository */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function find(string $id): ?User
    {
        return $this->repository->get($id);
    }

    /**
     * {@inheritDoc}
     */
    public function save(User $user): void
    {
        $this->repository->put($user->getAuthIdentifier(), $user, config('session.lifetime') * 60);
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $id): void
    {
        $this->repository->put($id, null, 0);
    }
}
