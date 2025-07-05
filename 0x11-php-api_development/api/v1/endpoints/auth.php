<?php
/**
 * api/v1/endpoints/auth.php
 *
 * Authentication endpoint for API v1.
 */

header("Content-Type: application/json");

echo json_encode([
    "version" => "v1",
    "endpoint" => "auth",
    "status" => "authenticated"
]);
?>
