<?php
/**
 * 9-backup_restore.php - Demonstrates command-line backup and restore of MySQL databases.
 * This script requires appropriate permissions and system access.
 */

require_once 'config/database.php';

$host = $dbConfig['host'];
$user = $dbConfig['username'];
$pass = $dbConfig['password'];
$dbname = $dbConfig['dbname'];
$backupFile = "backup_" . date("Ymd_His") . ".sql";

echo "Creating database backup...\n";

// Backup command
$backupCmd = "mysqldump -h{$host} -u{$user} -p{$pass} {$dbname} > {$backupFile}";
system($backupCmd, $output);

if (file_exists($backupFile)) {
    echo "Backup created successfully: {$backupFile}\n";
    
    // Example restore command (commented out for safety)
    // echo "Restoring database from backup...\n";
    // $restoreCmd = "mysql -h{$host} -u{$user} -p{$pass} {$dbname} < {$backupFile}";
    // system($restoreCmd, $output);
    // echo "Database restored from backup.\n";
} else {
    echo "Backup failed.\n";
}
