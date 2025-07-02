<?php
/**
 * Loads data from a JSON file into a PHP array.
 *
 * Usage: php 6-load_from_json_file.php
 */

$filename = 'data.json';

if (!file_exists($filename)) {
    echo "File '$filename' does not exist.\n";
    exit;
}

$jsonContent = file_get_contents($filename);
$data = json_decode($jsonContent, true);

if (json_last_error() === JSON_ERROR_NONE) {
    print_r($data);
} else {
    echo "JSON decode error: " . json_last_error_msg() . "\n";
}
