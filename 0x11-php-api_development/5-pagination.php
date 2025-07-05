<?php
/**
 * 5-pagination.php
 *
 * Demonstrates how to implement pagination in an API.
 */

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 2;

// Simulated dataset
$data = range(1, 10);

$total = count($data);
$start = ($page - 1) * $perPage;
$slice = array_slice($data, $start, $perPage);

echo json_encode([
    "page" => $page,
    "per_page" => $perPage,
    "total" => $total,
    "data" => $slice
]);
?>
Usage :
curl http://localhost:8000/5-pagination.php?page=2
