<?php
/**
 * Lazy Loading in PHP
 * 
 * Techniques to defer initialization of objects until they're needed.
 */

/**
 * 1. Basic Lazy Loading with Closure
 */
class LazyLoader
{
    private $heavyObject = null;
    private $initializer;
    
    public function __construct(Closure $initializer)
    {
        $this->initializer = $initializer;
    }
    
    public function get(): object
    {
        if ($this->heavyObject === null) {
            $this->heavyObject = ($this->initializer)();
        }
        return $this->heavyObject;
    }
}

// Usage:
$loader = new LazyLoader(function() {
    echo "Loading heavy object...\n";
    return new class {
        public function doWork() { echo "Working...\n"; }
    };
});

// Object not created yet
echo "Before first use\n";
$loader->get()->doWork(); // Object created here

/**
 * 2. Proxy Pattern for Lazy Loading
 */
interface DatabaseServiceInterface
{
    public function query(string $sql): array;
}

class DatabaseService implements DatabaseServiceInterface
{
    public function query(string $sql): array
    {
        echo "Executing query: $sql\n";
        // Actual database operations...
        return ['result' => 'data'];
    }
}

class DatabaseServiceProxy implements DatabaseServiceInterface
{
    private $realService = null;
    
    public function query(string $sql): array
    {
        if ($this->realService === null) {
            echo "Creating real database service...\n";
            $this->realService = new DatabaseService();
        }
        return $this->realService->query($sql);
    }
}

// Usage:
$proxy = new DatabaseServiceProxy();
echo "Proxy created, real service not initialized yet\n";
$result = $proxy->query("SELECT * FROM users"); // Service initialized here

/**
 * 3. Lazy Loading for Relationships (ORM-style)
 */
class User
{
    private $id;
    private $profile = null;
    private $profileLoader;
    
    public function __construct(int $id, Closure $profileLoader)
    {
        $this->id = $id;
        $this->profileLoader = $profileLoader;
    }
    
    public function getProfile(): Profile
    {
        if ($this->profile === null) {
            $this->profile = ($this->profileLoader)($this->id);
        }
        return $this->profile;
    }
}

class Profile
{
    private $userId;
    private $data;
    
    public function __construct(int $userId, array $data)
    {
        $this->userId = $userId;
        $this->data = $data;
    }
}

// Usage:
$user = new User(123, function(int $userId) {
    echo "Loading profile for user $userId...\n";
    return new Profile($userId, ['name' => 'John Doe']);
});

echo "User created, profile not loaded yet\n";
$profile = $user->getProfile(); // Profile loaded here

/**
 * Key Takeaways:
 * 1. Lazy loading improves initial load time
 * 2. Useful for resources that might not be needed
 * 3. Can complicate debugging if overused
 */
?>
