<?php

namespace Core\Models\Resource;

use Core\Connection\Database;
use Core\Models\DTOs\UserEntity;
use Core\Response;
use ReflectionClass;

abstract class Model
{
    // use ModelHandler;
    use ModelComponents;

    protected $table;
    protected array $fillable = [];
    protected $primaryKey = 'id';

    private ?Database $connection = null;

    // private array $response = ["status" => "", "message" => "", "data" => []];

    public function __construct()
    {

        $this->connection ?? $this->connection = Database::getConnection();

        if (!$this->table) {
            $className = strtolower((new ReflectionClass($this)->getShortName()));
            $this->table = "{$className}s";
        }
    }


    public function create(array $data): ?UserEntity
    {

        $existingUser = $this->findBy('email', [$data['email'] ?? '']);
        if ($existingUser) {
            // dd(["email" => "ser already exists"]);
           //returning more than one value
            session_flash(['email' => ["acccount already exist"]]);

            session_old($data);
            redirect()->back()->setStatus(Response::REDIRECT)->send();
            exit;
        }

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        // Filter data to only fillable fields
        $filteredData = $this->filterFillable($data);


        //Add required fields
        $filteredData = $this->addFields([
            ['created_at', date('Y-m-d H:i:s')],
            ['updated_at', date('Y-m-d H:i:s')]
        ], $filteredData);

        $columns = array_keys($filteredData);

        $placeholders = array_map(fn($col) => ":$col", $columns);


        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";

        $this->connection->query($sql, $filteredData);

        $email = $filteredData['email'];
        //get last insert id from email

        $userData = $this->findBy('email', [$email]);

        if (!empty($userData)) {
            // $this->response['status'] = 'success';
            // $this->response['message'] = 'User create successfully';
            // $this->response['data'] = $userData;
            return new UserEntity($userData['id'], $userData['email'], $userData['created_at']);
            // return $userData;
        } else {
            session_flash(["email" => "ser already exists"]);
            session_old($data);
            redirect()->back()->setStatus(Response::REDIRECT)->send();
            exit;
        }
    }


    public function findBy($field, array $value)
    {
        $placeholder = ":$field";
        $value = [$field => $value[0]];
        // dd($value);
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = {$placeholder} LIMIT 1";
        $stmt = $this->connection->query($sql, $value);
        return $stmt->fetch();
    }

    public function fetchAll() {}
}
