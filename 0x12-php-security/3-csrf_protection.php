<?php
/**
 * CSRF (Cross-Site Request Forgery) protection
 */

session_start();

// Generate CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Validate CSRF token
function validateCsrfToken($token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        throw new RuntimeException("Invalid CSRF token");
    }
    return true;
}

// Example form with CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $csrfToken = generateCsrfToken();
    ?>
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        <input type="text" name="username" placeholder="Username">
        <button type="submit">Submit</button>
    </form>
    <?php
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validateCsrfToken($_POST['csrf_token'] ?? '');
        
        // Process the form data
        $username = $_POST['username'] ?? '';
        echo "Form submitted successfully for user: " . htmlspecialchars($username);
        
        // Regenerate token after successful validation
        unset($_SESSION['csrf_token']);
    } catch (RuntimeException $e) {
        http_response_code(403);
        echo "Security error: " . $e->getMessage();
    }
}
?>
