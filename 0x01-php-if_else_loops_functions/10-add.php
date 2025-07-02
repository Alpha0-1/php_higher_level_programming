<?php
// 10-add.php
/**
 * Adds two integers and displays result
 * Example: php 10-add.php 5 3
 * Output: 5 + 3 = 8
 */

$num1 = $argv[1] ?? 0;
$num2 = $argv[2] ?? 0;

$sum = $num1 + $num2;
echo "$num1 + $num2 = $sum\n";
?>
