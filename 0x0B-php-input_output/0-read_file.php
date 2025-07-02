<?php
/**
 * Reads and displays the contents of a text file.
 *
 * Usage: php 0-read_file.php
 */

$filename = 'sample.txt';

if (file_exists($filename)) {
    $content = file_get_contents($filename);
    echo "File content:\n" . $content;
} else {
    echo "Error: File '$filename' not found.\n";
}
