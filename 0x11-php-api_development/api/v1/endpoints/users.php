<?php
/**
 * api/v1/endpoints/users.php
 *
 * Users endpoint for API v1.
 */

header("Content-Type: application/json");

echo json_encode([
    "version" => "v1",
    "endpoint" => "users",
    "data" => ["id" => 1, "name" => "Alice"]
]);
?>
