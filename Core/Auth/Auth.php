<?php

namespace Core\Auth;

use Core\Models\DTOs\UserEntity;

//needs to implement authinterface for louse coupling 
class Auth 
{

    public function __construct(private AuthInterface $authProvider) {}

    public function login(array $user): ?array
    {
        // return $authProvider->
        return $this->authProvider->login($user);
    }
    public function logout(): void
    {
        // return $authProvider->
         $this->authProvider->logout();
    }
    public function user(): array|null
    {
        // return $authProvider->
        return $this->authProvider->user();
    }
    public function verify(): bool
    {
        // return $authProvider->
        return $this->authProvider->verify();
    }
    public function authenticate(): array
    {
        // return $authProvider->
        return $this->authProvider->authenticate();
    }
}


