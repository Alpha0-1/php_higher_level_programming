<?php
// 8-toupper.php
/**
 * Converts a lowercase character to uppercase
 * Example: php 8-toupper.php a
 * Output: A
 */

$char = $argv[1] ?? '';

if (strlen($char) != 1) {
    echo "Please provide a single character\n";
    exit(1);
}

if ($char >= 'a' && $char <= 'z') {
    $offset = ord($char) - ord('a');
    echo chr(ord('A') + $offset) . "\n";
} else {
    echo "$char is not lowercase\n";
}
?>
