<?php
/**
 * Converts a JSON string back into a PHP array.
 *
 * Usage: php 4-from_json_string.php
 */

$jsonString = '{"name":"Bob","age":30,"is_student":false}';
$data = json_decode($jsonString, true); // true returns associative array

if (json_last_error() === JSON_ERROR_NONE) {
    print_r($data);
} else {
    echo "JSON decoding error: " . json_last_error_msg() . "\n";
}
