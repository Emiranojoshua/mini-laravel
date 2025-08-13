<?php

namespace Core\Auth;

class Auth implements AuthProvider
{

    public function __construct(private AuthService $authProvider) {}

    public function login(array $user): bool
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


