<?php

namespace Core\Auth;

use Core\Models\DTOs\UserEntity;
use Core\Response\Responsable;

interface AuthInterface extends Responsable
{
    public function login(array $credentials): ?UserEntity;

    public function logout(): void;

    public function user(): ?UserEntity;

    /** Returns true if the current request is authenticated. */
    public function verify(): bool;

    /**
     * Ensures request is authenticated; throws if not.
     */
    public function authenticate(): array;
}
