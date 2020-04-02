<?php

namespace S25\Auth\UserProvider;


use S25\Auth\User;

interface UserProviderInterface
{
    public function getByUid(string $uid): ?User;
}
