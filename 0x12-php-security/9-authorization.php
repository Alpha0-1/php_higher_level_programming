<?php
/**
 * Authorization system with role-based access control (RBAC)
 */

require_once '8-authentication.php'; // Depends on authentication

class AuthorizationSystem {
    private $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    // Check if user has a specific permission
    public function hasPermission($userId, $permission) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM user_roles ur
            JOIN role_permissions rp ON ur.role_id = rp.role_id
            JOIN permissions p ON rp.permission_id = p.id
            WHERE ur.user_id = ? AND p.name = ?
        ");
        $stmt->execute([$userId, $permission]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Check if user has any of the specified permissions
    public function hasAnyPermission($userId, array $permissions) {
        $placeholders = implode(',', array_fill(0, count($permissions), '?'));
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM user_roles ur
            JOIN role_permissions rp ON ur.role_id = rp.role_id
            JOIN permissions p ON rp.permission_id = p.id
            WHERE ur.user_id = ? AND p.name IN ($placeholders)
        ");
        $stmt->execute(array_merge([$userId], $permissions));
        return $stmt->fetchColumn() > 0;
    }
    
    // Middleware for route protection
    public function protectRoute($requiredPermission) {
        if (!isset($_SESSION['user_id'])) {
            header("HTTP/1.1 401 Unauthorized");
            exit("Unauthorized");
        }
        
        if (!$this->hasPermission($_SESSION['user_id'], $requiredPermission)) {
            header("HTTP/1.1 403 Forbidden");
            exit("Forbidden");
        }
    }
}

// Example usage
try {
    $pdo = new PDO("mysql:host=localhost;dbname=auth_db", "dbuser", "dbpass");
    $auth = new AuthSystem($pdo);
    $authorization = new AuthorizationSystem($pdo);
    
    // Example route protection
    if (isset($_GET['admin'])) {
        $authorization->protectRoute('admin_access');
        echo "Welcome to admin area!";
    }
    
    // Check permissions in views
    if ($auth->isLoggedIn()) {
        $userId = $_SESSION['user_id'];
        
        if ($authorization->hasPermission($userId, 'edit_content')) {
            echo '<a href="/edit">Edit Content</a>';
        }
        
        if ($authorization->hasAnyPermission($userId, ['delete_content', 'admin_access'])) {
            echo '<a href="/delete">Delete Content</a>';
        }
    }
    
    // Example permission checks
    if ($authorization->hasPermission($_SESSION['user_id'] ?? 0, 'view_reports')) {
        echo '<a href="/reports">View Reports</a>';
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Database schema example for RBAC:
/*
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
);

CREATE TABLE user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
*/
?>
