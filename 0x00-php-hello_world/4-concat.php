<?php
/**
 * 4-concat.php - String Concatenation Examples
 * 
 * This script demonstrates various methods of string concatenation in PHP.
 * Shows different approaches to combining strings and variables.
 * 
 * Learning objectives:
 * - String concatenation operator (.)
 * - Variable interpolation
 * - Different concatenation techniques
 * 
 * Usage: php 4-concat.php
 */

$greeting = "Hello";
$target = "World";
$language = "PHP";

// Method 1: Concatenation operator
$message1 = $greeting . ", " . $target . "!";
echo "Method 1: " . $message1 . "\n";

// Method 2: Direct concatenation with echo
echo "Method 2: " . $greeting . ", " . $target . " from " . $language . "!\n";

// Method 3: Variable interpolation (double quotes)
$message3 = "$greeting, $target from $language!";
echo "Method 3: $message3\n";

// Method 4: Complex concatenation
$fullMessage = "Learning " . $language . " is " . "awesome" . "!";
echo "Method 4: $fullMessage\n";

// Method 5: Concatenation assignment operator (.=)
$progressive = "Step 1";
$progressive .= " -> Step 2";
$progressive .= " -> Step 3";
echo "Method 5: $progressive\n";
?>
