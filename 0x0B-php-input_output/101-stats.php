<?php
/**
 * Logs access stats to a file and reads them.
 *
 * Usage: php 101-stats.php
 */

$logFile = 'access.log';
$message = "User accessed at " . date('Y-m-d H:i:s') . "\n";

file_put_contents($logFile, $message, FILE_APPEND);

echo "Access logged.\n";
echo "Current logs:\n" . file_get_contents($logFile);
