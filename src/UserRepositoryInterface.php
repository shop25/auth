<?php

namespace S25\Auth;


interface UserRepositoryInterface
{
    /**
     * @param string $id
     * @return User|null
     */
    public function find(string $id): ?User;

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void;

    /**
     * @param string $id
     */
    public function remove(string $id): void;
}
