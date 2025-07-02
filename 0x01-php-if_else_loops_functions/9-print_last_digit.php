<?php
// 9-print_last_digit.php
/**
 * Prints the last digit of a number
 * Example: php 9-print_last_digit.php -123
 * Output: 3
 */

$number = abs($argv[1] ?? 0);
echo $number % 10 . "\n";
?>
