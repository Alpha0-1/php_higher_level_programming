<?php
/**
 * Secure authentication system
 */

require_once '4-password_hashing.php'; // For password functions
require_once '5-session_security.php'; // For secure sessions

class AuthSystem {
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function register($username, $password, $email) {
        // Validate inputs
        if (empty($username) || empty($password) || empty($email)) {
            throw new InvalidArgumentException("All fields are required");
        }
        
        // Check if username exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            throw new RuntimeException("Username already exists");
        }
        
        // Check if email exists
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            throw new RuntimeException("Email already registered");
        }
        
        // Create password hash
        $passwordHash = createPasswordHash($password);
        
        // Insert new user
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password_hash, email, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $passwordHash, $email]);
        
        return $this->pdo->lastInsertId();
    }
    
    public function login($username, $password) {
        // Find user by username
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !verifyPassword($password, $user['password_hash'])) {
            throw new RuntimeException("Invalid username or password");
        }
        
        // Start secure session
        secureSessionStart();
        
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();
        
        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);
        
        return true;
    }
    
    public function logout() {
        // Destroy all session data
        $_SESSION = [];
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
        session_destroy();
    }
    
    public function isLoggedIn() {
        if (!isset($_SESSION['logged_in']) {
            return false;
        }
        
        // Check session activity timeout (30 minutes)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            $this->logout();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
        return true;
    }
}

// Example usage
try {
    $pdo = new PDO("mysql:host=localhost;dbname=auth_db", "dbuser", "dbpass");
    $auth = new AuthSystem($pdo);
    
    // Registration example
    // $auth->register('new_user', 'SecurePass123!', 'user@example.com');
    
    // Login example
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
        $auth->login($_POST['username'], $_POST['password']);
        echo "Login successful! Welcome " . htmlspecialchars($_POST['username']);
    }
    
    // Check if logged in
    if ($auth->isLoggedIn()) {
        echo "You are logged in as " . htmlspecialchars($_SESSION['username']);
    } else {
        // Show login form
        ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php
    }
    
    // Logout example
    if (isset($_GET['logout'])) {
        $auth->logout();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
