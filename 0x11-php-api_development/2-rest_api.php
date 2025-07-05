<?php
/**
 * 2-rest_api.php
 *
 * Demonstrates a RESTful API with GET and POST methods.
 */

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(["message" => "GET request received"]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    echo json_encode([
        "message" => "POST request received",
        "data" => $input
    ]);
}
?>
Usage :
GET: curl http://localhost:8000/2-rest_api.php
POST: curl -X POST -H "Content-Type: application/json" -d '{"key":"value"}' http://localhost:8000/2-rest_api.php
