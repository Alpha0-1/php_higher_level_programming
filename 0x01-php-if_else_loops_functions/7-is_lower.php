<?php
// 7-islower.php
/**
 * Checks if a character is lowercase
 * Example: php 7-islower.php a
 * Output: 'a' is lowercase
 */

$char = $argv[1] ?? '';

if (strlen($char) != 1) {
    echo "Please provide a single character\n";
    exit(1);
}

if ($char >= 'a' && $char <= 'z') {
    echo "'$char' is lowercase\n";
} else {
    echo "'$char' is not lowercase\n";
}
?>
