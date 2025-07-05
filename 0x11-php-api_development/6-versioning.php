<?php
/**
 * 6-versioning.php
 *
 * Shows how to handle API versioning through query parameters.
 */

$version = $_GET['version'] ?? 'v1';

if ($version === 'v1') {
    echo json_encode(["message" => "You are using v1"]);
} elseif ($version === 'v2') {
    echo json_encode(["message" => "You are using v2", "new_feature" => true]);
} else {
    echo json_encode(["error" => "Unsupported version"]);
}
?>
/**
 * Usage :
 * curl http://localhost:8000/6-versioning.php?version=v2
 */
