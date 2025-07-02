<?php
// 4-print_alphabet_excl.php
/**
 * Prints lowercase alphabet excluding q and e
 * Example: php 4-print_alphabet_excl.php
 * Output: abcdfghijklmnoprsuvwxyz
 */

for ($char = 'a'; $char <= 'z'; $char++) {
    if ($char != 'q' && $char != 'e') {
        echo $char;
    }
}
echo "\n";
?>
