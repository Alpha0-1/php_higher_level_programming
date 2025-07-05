<?php
/**
 * 7-documentation.php
 *
 * Provides basic documentation for available API endpoints.
 */

$docs = [
    "/0-simple_api.php" => "Returns plain text message",
    "/1-json_api.php" => "Returns JSON-formatted user data",
    "/2-rest_api.php" => "Supports GET and POST methods",
    "/3-authentication.php" => "Requires X-API-Key header",
    "/4-rate_limiting.php" => "Limits to 5 requests per minute",
    "/5-pagination.php" => "Supports page parameter",
    "/6-versioning.php" => "Accepts version parameter"
];

header("Content-Type: application/json");
echo json_encode(["documentation" => $docs], JSON_PRETTY_PRINT);
?>
