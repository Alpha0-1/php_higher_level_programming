<?php
/**
 * Reloads and updates student data from a JSON file.
 *
 * Usage: php 11-student.php
 */

$filename = 'students.json';

if (!file_exists($filename)) {
    file_put_contents($filename, json_encode([]));
}

$students = json_decode(file_get_contents($filename), true);
array_push($students, ['name' => 'Eve', 'grade' => 'B']);
file_put_contents($filename, json_encode($students, JSON_PRETTY_PRINT));

echo "Student list updated.\n";
