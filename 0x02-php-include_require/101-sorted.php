<!-- 101-sorted.php -->
<?php
/**
 * Sorted Array Example
 * Demonstrates sorting associative arrays
 * @author Your Name
 * @license MIT
 */

$people = [
    'Charlie' => 28,
    'Alice' => 32,
    'Bob' => 25
];

echo "Original array:\n";
print_r($people);

// Sort by key
ksort($people);
echo "\nSorted by name (key):\n";
print_r($people);

// Sort by value
asort($people);
echo "\nSorted by age (value):\n";
print_r($people);
