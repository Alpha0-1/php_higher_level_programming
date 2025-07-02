<?php
// 101-remove_char_at.php
/**
 * Removes character at specified position
 * Example: php 101-remove_char_at.php hello 1
 * Output: hllo
 */

function removeCharAt(string $str, int $pos): string {
    if ($pos < 0 || $pos >= strlen($str)) {
        return "Invalid position";
    }
    return substr($str, 0, $pos) . substr($str, $pos+1);
}

echo removeCharAt($argv[1] ?? '', $argv[2] ?? 0) . "\n";
?>
