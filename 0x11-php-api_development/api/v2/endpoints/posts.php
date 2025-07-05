<?php
/**
 * api/v2/endpoints/posts.php
 *
 * Updated posts endpoint for API v2.
 */

header("Content-Type: application/json");

echo json_encode([
    "version" => "v2",
    "endpoint" => "posts",
    "data" => [
        ["id" => 101, "title" => "Introduction"],
        ["id" => 102, "title" => "Advanced Topics"]
    ]
]);
?>
