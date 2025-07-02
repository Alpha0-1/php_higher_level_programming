<!-- 102-concat.php -->
<?php
/**
 * File Concatenation
 * Combines multiple files into one output
 * @author Your Name
 * @license MIT
 */

$files = ['sample1.txt', 'sample2.txt'];
$output = '';

foreach ($files as $file) {
    if (file_exists($file)) {
        $output .= file_get_contents($file) . PHP_EOL;
    } else {
        echo "File not found: $file\n";
    }
}

echo "Combined content:\n" . $output;
