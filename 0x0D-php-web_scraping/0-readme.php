<?php
/**
 * Read file content and display it
 * 
 * This script demonstrates basic file reading operations in PHP
 * Usage: php 0-readme.php <filename>
 * 
 * @author Alpha0-1
 */

/**
 * Main function to read and display file content
 * 
 * @param string $filename The name of the file to read
 * @return void
 */
function readFileContent($filename) {
    // Check if filename is provided
    if (empty($filename)) {
        echo "Usage: php 0-readme.php <filename>\n";
        return;
    }
    
    // Check if file exists
    if (!file_exists($filename)) {
        echo "Error: File '$filename' not found.\n";
        return;
    }
    
    // Check if file is readable
    if (!is_readable($filename)) {
        echo "Error: File '$filename' is not readable.\n";
        return;
    }
    
    // Read and display file content
    $content = file_get_contents($filename);
    
    if ($content === false) {
        echo "Error: Could not read file '$filename'.\n";
        return;
    }
    
    echo $content;
}

// Get filename from command line arguments
$filename = isset($argv[1]) ? $argv[1] : '';

// Execute the function
readFileContent($filename);

/**
 * Alternative method using fopen/fread for large files
 * Uncomment to use this method instead
 */
/*
function readFileContentAlternative($filename) {
    $handle = fopen($filename, 'r');
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            echo $line;
        }
        fclose($handle);
    } else {
        echo "Error: Could not open file '$filename'.\n";
    }
}
*/

?>
