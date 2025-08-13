<?php

namespace Core\Auth;

use Core\Connection\Database;

final class AuthService implements AuthProvider
{

    private ?Database $connection = null;


    public function __construct()
    {

        $this->connection ?? $this->connection = Database::getConnection();
    }

    public function login(array $credentials): bool
    {
        if (empty($credentials)) {
            //throw empty exception;
        }
        $email    = trim($credentials['email'] ?? '');
        $password = $credentials['password'] ?? '';

        if ($email === '' || $password === '') {
            //throw exception here
            return false;
        }

        //fetch user from database 
        $query = "SELECT id, email, password FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->connection->query($query, ["email" => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            //throw exception here
            return false;
        }

        // Verify hashed password
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Store minimal user data in session
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'email' => $user['email'],
        ];

        // Prevent session fixation
        session_regenerate_id(true);

        return true;
    }
    public function logout(): void
    {
        // return "someting something";
    }
    public function user(): ?array
    {
        return ["someting something"];
    }
    public function verify(): bool
    {
        return false;
    }
    public function authenticate(): array
    {
        return ["someting something"];
    }
}
