<?php

namespace Core\Auth;

use Core\Connection\Database;
use Core\Exception\AuthException\EmptyCredentialsAuthException;
use Core\Exception\AuthException\UserNotFoundAuthException;
use Core\Response;

final class AuthService implements AuthInterface
{

    private ?Database $connection = null;


    public function __construct()
    {

        $this->connection ?? $this->connection = Database::getConnection();
    }

    public function login(array $credentials): bool
    {
        if (empty($credentials)) {
            throw EmptyCredentialsAuthException::throwException(
                "Empty credentials provided",
                Response::BAD_REQUEST
            );
        }
        $email    = trim($credentials['email'] ?? '');
        $password = $credentials['password'] ?? '';

        if ($email === '' || $password === '') {
            throw EmptyCredentialsAuthException::throwException(
                "Empty credentials provided",
                Response::BAD_REQUEST
            );
        }

        //fetch user from database 
        $query = "SELECT id, email, password FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->connection->query($query, ["email" => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            throw UserNotFoundAuthException::throwException(
                "User not found",
                Response::BAD_REQUEST
            );
        }

        // Verify hashed password
        // dd([$password, $user['password']]);
        // --- IGNORE ---
        if (!password_verify($password, $user['password'])) {
            //send user back to login page
            //fill the session with an error message
            session_flash(["Invalid credentials provided"]);
            redirect()->back()->setStatus(Response::UNAUTHORIZED)->send();
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
