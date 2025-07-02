<?php
/**
 * Appends a new line of text after a specific target line in a file.
 *
 * This script reads a file line by line, searches for a matching line,
 * and inserts the new text immediately after it. The file is then updated.
 *
 * Usage:
 *   php 100-append_after.php
 *
 * Make sure the file 'example.txt' exists before running this script.
 */

// Define the file to modify
$filename = 'example.txt';

// Set the target line to search for (exact match required)
$searchLine = 'Target Line';

// Define the line to insert after the target
$insertText = 'This is the inserted line.';

// Check if the file exists
if (!file_exists($filename)) {
    echo "Error: File '$filename' does not exist.\n";
    exit(1);
}

// Read all lines from the file
$lines = file($filename);

// Open the file for writing (will overwrite contents)
$fileHandler = fopen($filename, 'w');

if (!$fileHandler) {
    echo "Error: Could not open file '$filename' for writing.\n";
    exit(1);
}

// Loop through each line
foreach ($lines as $line) {
    // Write the current line
    fwrite($fileHandler, $line);

    // If this is the target line, append the new text
    if (trim($line) === $searchLine) {
        fwrite($fileHandler, $insertText . PHP_EOL);
    }
}

// Close the file handle
fclose($fileHandler);

echo "Successfully updated file: '$filename'.\n";
echo "Inserted line after: \"$searchLine\"\n";
