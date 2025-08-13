<?php

namespace Core\Connection;

use Core\Exception\DatabaseException\DatabaseException;
use Core\Response;
use PDO;
use PDOStatement;

class Database
{

    public  $connection;

    private PDOStatement $statement;

    private string $username;
    private string $password;
    private array $options;
    private string $dsn;

    private static $instance = null;

    public function __construct()
    {

        $this->username = env('username');
        $this->password = env('password');
        $this->dsn = "mysql:host=" . env('host') . ";dbname=" . env('database');
        $this->options = [];

        // dd($this->options);

        try {
            $this->connection = new PDO(
                $this->dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ],
            );
        } catch (\Throwable $e) {
            throw DatabaseException::throwException($e->getMessage(), Response::INTERNAL_SERVER_ERROR);
        }
    }

    public function query(String $query, array $param = []): PDOStatement
    {
        try {
            $this->statement = $this->connection->prepare($query);
            $this->statement->execute($param);
            return $this->statement;
        } catch (\Throwable $e) {
            throw DatabaseException::throwException($e->getMessage(), Response::INTERNAL_SERVER_ERROR);
        }
    }

    public static function getConnection()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }   
}
