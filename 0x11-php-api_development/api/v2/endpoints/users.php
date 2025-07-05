<?php
/**
 * api/v2/endpoints/users.php
 *
 * Updated users endpoint for API v2.
 */

header("Content-Type: application/json");

echo json_encode([
    "version" => "v2",
    "endpoint" => "users",
    "data" => [
        ["id" => 1, "name" => "Alice"],
        ["id" => 2, "name" => "Bob"]
    ]
]);
?>
