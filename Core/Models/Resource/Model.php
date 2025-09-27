<?php

namespace Core\Models\Resource;

use Core\Response\ResponseComponent;
use Core\Connection\Database;
use Core\Response\ResultStatus;
use ReflectionClass;

abstract class Model
{
    // use ModelHandler;
    use ModelComponents;
    use ResponseComponent;

    protected $table;
    protected array $fillable = [];
    protected $primaryKey = 'id';

    private ?Database $connection = null;

    public function __construct()
    {

        $this->connection ?? $this->connection = Database::getConnection();

        if (!$this->table) {
            $className = strtolower(new ReflectionClass($this)->getShortName());
            $this->table = "{$className}s";
        }
    }


    public function create(array $data): ?array
    {
        $existingUser = $this->findBy('email', [$data['email'] ?? '']);
        // dd("testing");
        // if($existingUser){
        //     dc($existingUser);
        //     dd("user exist");
        // }
        // dc($existingUser);
        // dd("user does not exist");

        if ($existingUser) {
            return $this->sendResponse(
                ResultStatus::FAILED,
                [
                    //remove and leave only generic errors
                    'email' => "acccount already exist",
                    'generic' => "account already exist"
                ],
                $data
            );
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
            return $this->sendResponse(
                status: ResultStatus::SUCCESS,
                responseData: $data,
            );
        } else {

            return $this->sendResponse(
                ResultStatus::FAILED,
                ['email' => ["Something went wrong"]],
                $data
            );
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
