<?php
/**
 * Saves a PHP array to a JSON file.
 *
 * Usage: php 5-save_to_json_file.php
 */

$filename = 'data.json';
$data = [
    "title" => "My Book",
    "author" => "Jane Doe",
    "pages" => 300
];

$jsonData = json_encode($data, JSON_PRETTY_PRINT);

if ($jsonData === false) {
    echo "JSON encoding failed: " . json_last_error_msg() . "\n";
} elseif (file_put_contents($filename, $jsonData) !== false) {
    echo "Data saved to '$filename'.\n";
} else {
    echo "Failed to save JSON data to file.\n";
}
