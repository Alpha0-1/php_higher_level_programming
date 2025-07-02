<?php
// 0-positive_or_negative.php
/**
 * Checks if a number is positive, negative, or zero
 * Example: php 0-positive_or_negative.php 5
 * Output: 5 is positive
 */

$number = $argv[1] ?? 0;

if ($number > 0) {
    echo "$number is positive\n";
} elseif ($number < 0) {
    echo "$number is negative\n";
} else {
    echo "Zero\n";
}
?>
