<?php
/**
 * 7-multi_c.php - Print C Multiple Times
 * 
 * This script demonstrates repetitive output using loops.
 * Shows different ways to repeat output a specific number of times.
 * 
 * Learning objectives:
 * - for loop usage
 * - Loop counters and conditions
 * - String repetition techniques
 * - Built-in PHP functions for repetition
 * 
 * Usage: php 7-multi_c.php [count]
 */

// Default count or from command line argument
$count = isset($argv[1]) && is_numeric($argv[1]) ? (int)$argv[1] : 10;

echo "Printing 'C' $count times:\n";
echo "=========================\n";

// Method 1: Simple for loop
echo "Method 1 - For loop:\n";
for ($i = 0; $i < $count; $i++) {
    echo "C";
    if (($i + 1) % 10 == 0) {
        echo "\n"; // New line every 10 characters
    }
}
echo "\n\n";

// Method 2: While loop
echo "Method 2 - While loop:\n";
$counter = 0;
while ($counter < $count) {
    echo "C";
    $counter++;
    if ($counter % 10 == 0) {
        echo "\n";
    }
}
echo "\n\n";

// Method 3: Using str_repeat() function
echo "Method 3 - str_repeat() function:\n";
$repeated = str_repeat("C", $count);
// Add line breaks every 10 characters
$formatted = chunk_split($repeated, 10, "\n");
echo $formatted;

// Method 4: Numbered output
echo "\nMethod 4 - Numbered output:\n";
for ($i = 1; $i <= $count; $i++) {
    echo "$i: C\n";
}
?>
