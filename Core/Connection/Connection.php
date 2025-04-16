<?php

namespace Core\Connection;

use Core\Exception\DatabaseException\DatabaseException;
use Core\Exception\Exceptions;
use Core\Response;
use PDO;
use PDOException;

class Connection
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
