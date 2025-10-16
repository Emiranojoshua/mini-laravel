<?php

namespace Core\Auth;

use Core\Connection\Database;
use Core\Models\DTOs\UserEntity;
use Core\Response\ResponseComponent;
use Core\Response\ResultStatus;

final class AuthService implements AuthInterface
{

    use ResponseComponent;

    private ?Database $connection = null;


    public function __construct()
    {

        $this->connection = $this->connection ?? Database::getConnection();
    }

    public function login(array $credentials): ?UserEntity
    {
        if (empty($credentials)) {
            return $this->sendResponse(
                ResultStatus::FAILED,
                [
                    "email" => "email is required",
                    "password" => "password is required",
                    "generic" => "empty form fields",
                ],
                $credentials
            );
        }
        $email = trim($credentials['email'] ?? '');
        $password = $credentials['password'] ?? '';

        if ($email === '' || $password === '') {
            return $this->sendResponse(
                ResultStatus::FAILED,
                [
                    "email" => "email is required",
                    "password" => "password is required",
                    "generic" => "empty form fields",
                ],
                $credentials
            );
        }

        //fetch user from database
        $query = "SELECT id, email, password FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->connection->query($query, ["email" => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            return $this->sendResponse(
                ResultStatus::FAILED,
                [
                    "email" => "user not found",
                    "password" => "user not found",
                    "generic" => "user not found",
                ],
                $credentials
            );
        }

        // Verify hashed password
        // dd([$password, $user['password']]);
        // --- IGNORE ---
        if (!password_verify($password, $user['password'])) {
            //send user back to login page
            //fill the session with an error message
            // session_flash(["Invalid credentials provided"]);
            // redirect(statusCode: Response::REDIRECT)->back();
            // return false;
            return $this->sendResponse(
                ResultStatus::FAILED,
                [
                    "email" => "Invalid user credentials",
                    "password" => "Invalid user credentials",
                    "generic" => "Invalid user credentials",
                ],
                $credentials
            );
        }

        // Store minimal user data in session
        session_regenerate_id(true);
        $loginedUser = new UserEntity($user['id'], $user['email']);
        session_add("user", $loginedUser);
        // return true;
        return $this->sendResponse(
            ResultStatus::SUCCESS,
            responseData: $loginedUser,
        );
    }
    public function logout(): void
    {
        // return "someting something";
    }
    public function user(): ?UserEntity
    {
        $user = session_get("user");

        // dd($user);
        if($user == null){
            dd("user is null and not logged in");
        }

        return $user;
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
