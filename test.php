<? 


/**
 * Simple Database Connection
 */
class Database
{
    private static $connection = null;
    
    public static function connect($config)
    {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
                self::$connection = new PDO($dsn, $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                throw new Exception('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
    
    public static function getConnection()
    {
        if (self::$connection === null) {
            throw new Exception('Database not connected. Call Database::connect() first.');
        }
        return self::$connection;
    }
}

/**
 * Simple Base Model
 */
abstract class Model
{
    protected $table;
    protected $fillable = [];
    protected $primaryKey = 'id';
    
    public function __construct()
    {
        if (!$this->table) {
            // Auto-generate table name from class name (User -> users)
            $className = strtolower((new ReflectionClass($this))->getShortName());
            $this->table = $className . 's';
        }
    }
    
    /**
     * Create a new record
     */
    public function create(array $data)
    {
        // Filter data to only fillable fields
        $filteredData = $this->filterFillable($data);
        
        // Add timestamps if not present
        if (!isset($filteredData['created_at'])) {
            $filteredData['created_at'] = date('Y-m-d H:i:s');
        }
        if (!isset($filteredData['updated_at'])) {
            $filteredData['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $columns = array_keys($filteredData);
        $placeholders = array_map(function($col) { return ':' . $col; }, $columns);
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";
        
        $stmt = Database::getConnection()->prepare($sql);
        
        foreach ($filteredData as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        if ($stmt->execute()) {
            $id = Database::getConnection()->lastInsertId();
            return $this->find($id);
        }
        
        return false;
    }
    
    /**
     * Find a record by ID
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Find a record by specific field
     */
    public function findBy($field, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = :value LIMIT 1";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Get all records
     */
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Update a record
     */
    public function update($id, array $data)
    {
        $filteredData = $this->filterFillable($data);
        $filteredData['updated_at'] = date('Y-m-d H:i:s');
        
        $sets = array_map(function($col) { return "{$col} = :{$col}"; }, array_keys($filteredData));
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->primaryKey} = :id";
        
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);
        
        foreach ($filteredData as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Delete a record
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);
        
        return $stmt->execute();
    }
    
    /**
     * Filter data to only include fillable fields
     */
    private function filterFillable(array $data)
    {
        if (empty($this->fillable)) {
            return $data; // If no fillable defined, allow all
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }
}

/**
 * User Model
 */
class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];
    
    /**
     * Create user with password hashing
     */
    public function create(array $data)
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return parent::create($data);
    }
    
    /**
     * Find user by email
     */
    public function findByEmail($email)
    {
        return $this->findBy('email', $email);
    }
    
    /**
     * Verify password
     */
    public function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}

/**
 * Request Class with Validation
 */
class Request
{
    private $data = [];
    private $errors = [];
    
    public function __construct()
    {
        // Merge GET and POST data
        $this->data = array_merge($_GET, $_POST);
        
        // Handle JSON input
        if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
            $json = json_decode(file_get_contents('php://input'), true);
            if ($json) {
                $this->data = array_merge($this->data, $json);
            }
        }
    }
    
    public function all()
    {
        return $this->data;
    }
    
    public function get($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }
    
    public function has($key)
    {
        return isset($this->data[$key]);
    }
    
    /**
     * Validate request data
     */
    public function validate(array $rules)
    {
        $this->errors = [];
        
        foreach ($rules as $field => $rule) {
            $this->validateField($field, $this->data[$field] ?? null, $rule);
        }
        
        return empty($this->errors);
    }
    
    private function validateField($field, $value, $rules)
    {
        $ruleArray = explode('|', $rules);
        
        foreach ($ruleArray as $rule) {
            if ($rule === 'required' && empty($value)) {
                $this->errors[$field][] = "{$field} is required";
            }
            
            if ($rule === 'email' && $value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field][] = "{$field} must be a valid email";
            }
            
            if (strpos($rule, 'min:') === 0) {
                $min = (int)substr($rule, 4);
                if ($value && strlen($value) < $min) {
                    $this->errors[$field][] = "{$field} must be at least {$min} characters";
                }
            }
            
            if (strpos($rule, 'max:') === 0) {
                $max = (int)substr($rule, 4);
                if ($value && strlen($value) > $max) {
                    $this->errors[$field][] = "{$field} must not exceed {$max} characters";
                }
            }
        }
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function hasErrors()
    {
        return !empty($this->errors);
    }
}

// Example Controller Usage - Updated for resolved parameters
/*
class UserController
{
    // Parameters are already resolved by your framework
    public function create(Request $request, Auth $auth, User $userModel)
    {
        // Validation rules
        $rules = [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
        
        // Validate using the request's validate method
        $validated = $request->validate($rules);
        
        if ($validated) {
            // If validation successful, create the user
            $user = $userModel->create($request->all());
            
            if ($user) {
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Failed to create user'];
            }
        } else {
            // Return validation errors
            return ['success' => false, 'errors' => $request->getErrors()];
        }
    }
}

// Alternative: If you prefer a separate Validator class
class Validator
{
    private $errors = [];
    
    public function validate(array $data, array $rules)
    {
        $this->errors = [];
        
        foreach ($rules as $field => $rule) {
            $this->validateField($field, $data[$field] ?? null, $rule);
        }
        
        return empty($this->errors);
    }
    
    // ... validation methods same as in Request class
    
    public function getErrors()
    {
        return $this->errors;
    }
}

// Controller with separate validator
class UserController2 
{
    public function create(Request $request, Auth $auth, User $userModel, Validator $validator)
    {
        $rules = [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
        
        // Pass request data to validator
        $validated = $validator->validate($request->all(), $rules);
        
        if ($validated) {
            $user = $userModel->create($request->all());
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'errors' => $validator->getErrors()];
        }
    }
}

// Initialize database connection (call this once in your bootstrap)
$config = [
    'host' => 'localhost',
    'database' => 'your_database',
    'username' => 'your_username',
    'password' => 'your_password'
];

Database::connect($config);
*/