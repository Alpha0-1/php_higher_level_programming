<?php
/**
 * Converts a PHP array to a JSON string.
 *
 * Usage: php 3-to_json_string.php
 */

$data = [
    "name" => "Alice",
    "age" => 25,
    "is_student" => true
];

$jsonString = json_encode($data, JSON_PRETTY_PRINT);

if ($jsonString === false) {
    echo "JSON encoding error: " . json_last_error_msg() . "\n";
} else {
    echo "Encoded JSON:\n" . $jsonString . "\n";
}
