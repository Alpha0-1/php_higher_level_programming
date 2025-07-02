<?php
/**
 * Adds a new item to an array stored in a JSON file.
 *
 * Usage: php 7-add_item.php
 */

$filename = 'students.json';

// Load current data
if (!file_exists($filename)) {
    $students = [];
} else {
    $json = file_get_contents($filename);
    $students = json_decode($json, true) ?? [];
}

// Add new student
$newStudent = ["name" => "Charlie", "grade" => "A"];
$students[] = $newStudent;

// Save back to JSON
file_put_contents($filename, json_encode($students, JSON_PRETTY_PRINT));

echo "Added new student to JSON file.\n";
