<?php
/**
 * Appends data to an existing file without overwriting it.
 *
 * Usage: php 2-append_write.php
 */

$filename = 'log.txt';
$newEntry = "New log entry at " . date('Y-m-d H:i:s') . "\n";

if (file_put_contents($filename, $newEntry, FILE_APPEND) !== false) {
    echo "Log entry added to '$filename'.\n";
} else {
    echo "Failed to append data to file.\n";
}
