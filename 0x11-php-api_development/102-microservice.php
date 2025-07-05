<?php
/**
 * 102-microservice.php
 *
 * Example microservice calling another service via HTTP.
 */

$httpClient = new GuzzleHttp\Client();

$response = $httpClient->get('http://localhost:8000/api/v1/endpoints/users.php');

echo $response->getBody();
?>
/**
 * This assumes a running microservice at /api/v1/endpoints/users.php
 */

