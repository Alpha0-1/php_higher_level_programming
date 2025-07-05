<?php
/**
 * 4-rate_limiting.php
 *
 * Implements a simple rate limiter (e.g., 5 requests per minute).
 */

session_start();

$limit = 5;
$window = 60; // seconds

$requestTime = time();
$ip = $_SERVER['REMOTE_ADDR'];

if (!isset($_SESSION[$ip])) {
    $_SESSION[$ip] = [];
}

// Clean up old timestamps
$_SESSION[$ip] = array_filter($_SESSION[$ip], fn($t) => $t > $requestTime - $window);

if (count($_SESSION[$ip]) >= $limit) {
    header("HTTP/1.1 429 Too Many Requests");
    echo json_encode(["error" => "Rate limit exceeded"]);
    exit;
}

$_SESSION[$ip][] = $requestTime;

echo json_encode(["message" => "Request accepted"]);
?>
Usage :
Repeatedly call this endpoint via curl and observe the 429 error after 5 calls in under 60 seconds.
