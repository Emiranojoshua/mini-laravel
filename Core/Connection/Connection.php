<?php

namespace Core\Connection;

use Core\Exception\Exceptions;
use PDO;

class Connection
{

    public  $connection;

    private $statement;

    private string $username;
    private string $password;
    private array $options;
    private string $dsn;

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
            // dd('this was called from moel exte');
            exception(Exceptions::DATABASEEXCEPTION->throw($e->getMessage()));
        }
    }

    public function query(String $query, $param = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($param);
        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }
}
