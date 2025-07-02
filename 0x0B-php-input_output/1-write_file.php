<?php
/**
 * Writes data into a new file or overwrites an existing one.
 *
 * Usage: php 1-write_file.php
 */

$filename = 'output.txt';
$data = "Hello, this is some sample text.";

if (file_put_contents($filename, $data) !== false) {
    echo "Data successfully written to '$filename'.\n";
} else {
    echo "Failed to write data to file.\n";
}
