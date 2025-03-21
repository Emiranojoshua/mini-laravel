<?php

namespace Core\Connection;

use Core\Exception\DatabaseException\DatabaseException;
use Core\Response;
use PDO;
use PDOException;

class ConnectionHandler
{

    private  $connection;

    private $statement;


    public function __construct(string $username = 'root', string $password = '')
    {

        $host = 'localhost';
        $database = 'emirano';

        $dsn = "mysql:host=$host;dbname=$database";
       

        try {
            $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (\Throwable $e) {

            DatabaseException::ThrowException(
                Response::SERVER_ERROR,
                $e->getMessage()
            );
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
