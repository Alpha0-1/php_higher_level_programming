<?php
/**
 * Filters students by grade from a JSON file.
 *
 * Usage: php 10-student.php
 */

$filename = 'students.json';

if (!file_exists($filename)) {
    echo "No students file found.\n";
    exit;
}

$data = json_decode(file_get_contents($filename), true);
$filtered = array_filter($data, fn($s) => $s['grade'] === 'A');

print_r($filtered);
