<?php
/**
 * Secure session handling
 */

// 1. Secure session configuration
function secureSessionStart() {
    $sessionName = 'SECUREAPP'; // Set a custom session name
    $secure = true; // Only send cookies over HTTPS
    $httponly = true; // Prevent JavaScript access to session cookie
    
    // Forces sessions to only use cookies
    ini_set('session.use_only_cookies', 1);
    
    // Gets current cookies params
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams["lifetime"],
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => $secure,
        'httponly' => $httponly,
        'samesite' => 'Strict' // Prevent CSRF
    ]);
    
    session_name($sessionName);
    session_start();
    
    // Regenerate session ID to prevent session fixation
    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
    }
}

// 2. Regenerate session ID periodically
function regenerateSession() {
    // Regenerate ID every 30 minutes
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// 3. Validate session to prevent hijacking
function validateSession() {
    // Check user agent consistency
    if (isset($_SESSION['user_agent'])) {
        if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            // Possible session hijacking attempt
            session_destroy();
            throw new RuntimeException("Session validation failed");
        }
    } else {
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    }
    
    // Check IP address (optional - can cause problems with mobile users)
    if (isset($_SESSION['ip_address'])) {
        if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR']) {
            // Possible session hijacking attempt
            session_destroy();
            throw new RuntimeException("Session validation failed");
        }
    } else {
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    }
}

// Example usage
secureSessionStart();
regenerateSession();
validateSession();

// Store user data in session
$_SESSION['user_id'] = 123;
$_SESSION['username'] = 'secure_user';

echo "Session is secure. User: " . htmlspecialchars($_SESSION['username']);
?>
