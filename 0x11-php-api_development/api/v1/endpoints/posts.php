<?php
/**
 * api/v1/endpoints/posts.php
 *
 * Posts endpoint for API v1.
 */

header("Content-Type: application/json");

echo json_encode([
    "version" => "v1",
    "endpoint" => "posts",
    "data" => ["id" => 101, "title" => "My First Post"]
]);
?>
