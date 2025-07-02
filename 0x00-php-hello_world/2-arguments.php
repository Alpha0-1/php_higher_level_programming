<?php
/**
 * 2-arguments.php - Command Line Arguments Processing
 * 
 * This script demonstrates how to access and process command-line arguments
 * passed to a PHP script. The $argv superglobal contains all arguments.
 * 
 * Learning objectives:
 * - Understanding $argv superglobal
 * - Accessing command-line arguments
 * - Basic argument validation
 * 
 * Usage: php 2-arguments.php arg1 arg2 arg3
 * Example: php 2-arguments.php Hello World PHP
 */

// Check if arguments were provided
if ($argc > 1) {
    echo "Arguments provided:\n";
    // Start from index 1 to skip the script name (index 0)
    for ($i = 1; $i < $argc; $i++) {
        echo "Argument $i: " . $argv[$i] . "\n";
    }
} else {
    echo "No arguments provided. Usage: php 2-arguments.php <arg1> <arg2> ...\n";
}

echo "Total arguments (including script name): $argc\n";
?>
