<?php

namespace Core\Auth;

use Core\Response\Responsable;

interface AuthInterface extends Responsable
{
    public function login(array $credentials): ?array;

    public function logout(): void;

    public function user(): ?array;

    /** Returns true if the current request is authenticated. */
    public function verify(): bool;

    /**
     * Ensures request is authenticated; throws if not.
     */
    public function authenticate(): array;
}
