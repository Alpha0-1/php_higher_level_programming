<?php
/**
 * 3-authentication.php
 *
 * Demonstrates basic API authentication using an API key.
 */

$validApiKey = "secret123";

if (!isset($_SERVER['HTTP_X_API_KEY']) || $_SERVER['HTTP_X_API_KEY'] !== $validApiKey) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

echo json_encode(["message" => "Authentication successful"]);
?>
Usage :
curl -H "X-API-Key: secret123" http://localhost:8000/3-authentication.php
