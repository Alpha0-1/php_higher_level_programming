<?php
// 12-fizzbuzz.php
/**
 * Classic FizzBuzz implementation
 * Example: php 12-fizzbuzz.php
 * Output: 1 2 Fizz 4 Buzz Fizz...
 */

for ($i = 1; $i <= 100; $i++) {
    if ($i % 15 == 0) {
        echo "FizzBuzz ";
    } elseif ($i % 3 == 0) {
        echo "Fizz ";
    } elseif ($i % 5 == 0) {
        echo "Buzz ";
    } else {
        echo "$i ";
    }
}
echo "\n";
?>
