<?php
/**
 * 5-no_c.php
 *
 * This script removes all 'c' and 'C' characters from a string.
 */

function removeCFromStr($str) {
    return str_ireplace('c', '', $str);
}

// Example usage
$input = "Concentration creates calm";
$output = removeCFromStr($input);

echo "Original: $input" . PHP_EOL;
echo "Modified: $output" . PHP_EOL;

/**
 * Output:
 * Original: Concentration creates calm
 * Modified: onentration reates alm
 */
?>
