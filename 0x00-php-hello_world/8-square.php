<?php
/**
 * 8-square.php - Print Square Pattern
 * 
 * This script creates square patterns using nested loops.
 * Demonstrates 2D output formatting and nested loop concepts.
 * 
 * Learning objectives:
 * - Nested loops
 * - 2D pattern creation
 * - String formatting
 * - Mathematical relationships in loops
 * 
 * Usage: php 8-square.php [size]
 * Example: php 8-square.php 5
 */

// Get size from command line or use default
$size = isset($argv[1]) && is_numeric($argv[1]) ? (int)$argv[1] : 5;

// Validate size
if ($size <= 0) {
    echo "Please provide a positive integer for square size.\n";
    exit(1);
}

echo "Creating a {$size}x{$size} square:\n";
echo str_repeat("=", $size * 2) . "\n";

// Method 1: Solid square
echo "Solid Square:\n";
for ($row = 0; $row < $size; $row++) {
    for ($col = 0; $col < $size; $col++) {
        echo "* ";
    }
    echo "\n";
}

echo "\n";

// Method 2: Hollow square
echo "Hollow Square:\n";
for ($row = 0; $row < $size; $row++) {
    for ($col = 0; $col < $size; $col++) {
        // Print * for border, space for inside
        if ($row == 0 || $row == $size - 1 || $col == 0 || $col == $size - 1) {
            echo "* ";
        } else {
            echo "  ";
        }
    }
    echo "\n";
}

echo "\n";

// Method 3: Numbered square
echo "Numbered Square:\n";
for ($row = 1; $row <= $size; $row++) {
    for ($col = 1; $col <= $size; $col++) {
        echo $col . " ";
    }
    echo "\n";
}

echo "\n";

// Method 4: Diagonal pattern
echo "Diagonal Pattern:\n";
for ($row = 0; $row < $size; $row++) {
    for ($col = 0; $col < $size; $col++) {
        if ($row == $col || $row + $col == $size - 1) {
            echo "* ";
        } else {
            echo ". ";
        }
    }
    echo "\n";
}
?>
