<?php
/**
 * 100-print_cli_array.php
 *
 * This script prints the contents of an array via command-line interface (CLI).
 * Usage: php 100-print_cli_array.php
 */

if (php_sapi_name() !== 'cli') {
    die("This script must be run via CLI.");
}

$args = $argv; // Get command-line arguments
array_shift($args); // Remove script name

echo "You passed the following arguments:" . PHP_EOL;
foreach ($args as $arg) {
    echo "- $arg" . PHP_EOL;
}

/**
 * Example CLI Run:
 * php 100-print_cli_array.php apple banana cherry
 *
 * Output:
 * You passed the following arguments:
 * - apple
 * - banana
 * - cherry
 */
?>
