<?php
// 1-last_digit.php
/**
 * Gets last digit of a number and checks conditions
 * Example: php 1-last_digit.php 1234
 * Output: Last digit 4 is even and less than 5
 */

$number = abs($argv[1] ?? 0);
$lastDigit = $number % 10;

echo "Last digit $lastDigit is ";
if ($lastDigit % 2 == 0) {
    echo "even";
} else {
    echo "odd";
}

if ($lastDigit < 5) {
    echo " and less than 5\n";
} elseif ($lastDigit > 5) {
    echo " and greater than 5\n";
} else {
    echo " and equal to 5\n";
}
?>
