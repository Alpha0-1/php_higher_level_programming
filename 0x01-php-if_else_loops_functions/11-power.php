<?php
// 11-power.php
/**
 * Calculates power of a number without pow()
 * Example: php 11-power.php 2 5
 * Output: 2^5 = 32
 */

function power(int $base, int $exponent): int {
    $result = 1;
    for ($i = 0; $i < $exponent; $i++) {
        $result *= $base;
    }
    return $result;
}

$base = $argv[1] ?? 0;
$exp = $argv[2] ?? 0;
echo "$base^$exp = " . power($base, $exp) . "\n";
?>
