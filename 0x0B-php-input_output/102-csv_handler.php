<?php
/**
 * Demonstrates reading and writing CSV files.
 *
 * Usage: php 102-csv_handler.php
 */

$csvFile = 'data.csv';

// Write CSV
$data = [
    ['Name', 'Age', 'City'],
    ['Alice', 25, 'Paris'],
    ['Bob', 30, 'London']
];

$file = fopen($csvFile, 'w');
foreach ($data as $row) {
    fputcsv($file, $row);
}
fclose($file);
echo "CSV written.\n";

// Read CSV
$file = fopen($csvFile, 'r');
while (($row = fgetcsv($file)) !== false) {
    print_r($row);
}
fclose($file);
