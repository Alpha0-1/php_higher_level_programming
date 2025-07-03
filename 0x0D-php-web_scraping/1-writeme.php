<?php
/**
 * Write content to a file
 * 
 * This script demonstrates file writing operations in PHP
 * Usage: php 1-writeme.php <filename> <content>
 * 
 * @author Alpha0-1
 */

/**
 * Write content to a specified file
 * 
 * @param string $filename The name of the file to write to
 * @param string $content The content to write
 * @return void
 */
function writeToFile($filename, $content) {
    // Check if filename is provided
    if (empty($filename)) {
        echo "Usage: php 1-writeme.php <filename> <content>\n";
        return;
    }
    
    // Check if content is provided
    if (empty($content)) {
        echo "Warning: No content provided. Creating empty file.\n";
        $content = '';
    }
    
    // Attempt to write to file
    $bytesWritten = file_put_contents($filename, $content);
    
    if ($bytesWritten === false) {
        echo "Error: Could not write to file '$filename'.\n";
        echo "Check permissions and disk space.\n";
        return;
    }
    
    echo "Successfully written $bytesWritten bytes to '$filename'.\n";
}

/**
 * Alternative method with error handling and backup
 * 
 * @param string $filename The name of the file to write to
 * @param string $content The content to write
 * @return bool Success status
 */
function writeToFileSecure($filename, $content) {
    // Create backup if file exists
    if (file_exists($filename)) {
        $backupName = $filename . '.backup.' . date('Y-m-d_H-i-s');
        if (!copy($filename, $backupName)) {
            echo "Warning: Could not create backup file.\n";
        } else {
            echo "Backup created: $backupName\n";
        }
    }
    
    // Write to temporary file first
    $tempFile = $filename . '.tmp';
    $result = file_put_contents($tempFile, $content, LOCK_EX);
    
    if ($result === false) {
        echo "Error: Could not write to temporary file.\n";
        return false;
    }
    
    // Move temporary file to final location
    if (!rename($tempFile, $filename)) {
        echo "Error: Could not move temporary file to final location.\n";
        unlink($tempFile); // Clean up
        return false;
    }
    
    return true;
}

// Get arguments from command line
$filename = isset($argv[1]) ? $argv[1] : '';
$content = isset($argv[2]) ? $argv[2] : '';

// Execute the function
writeToFile($filename, $content);

?>
