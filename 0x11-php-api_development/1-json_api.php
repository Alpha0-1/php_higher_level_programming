<?php
/**
 * 1-json_api.php
 *
 * Returns JSON-formatted data from an API endpoint.
 */

// Set response content type
header("Content-Type: application/json");

// Sample data
$data = [
    "message" => "Success",
    "data" => [
        "id" => 1,
        "name" => "Alice"
    ]
];

// Output JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>

Usage :
curl http://localhost:8000/1-json_api.php
