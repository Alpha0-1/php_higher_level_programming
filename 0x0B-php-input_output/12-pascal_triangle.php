<?php
/**
 * Generates Pascal's Triangle up to n rows.
 *
 * Usage: php 12-pascal_triangle.php
 */

function generatePascalTriangle($rows) {
    $triangle = [];

    for ($i = 0; $i < $rows; $i++) {
        $row = [1];
        for ($j = 1; $j < $i; $j++) {
            $row[] = $triangle[$i-1][$j-1] + $triangle[$i-1][$j];
        }
        if ($i > 0) $row[] = 1;
        $triangle[] = $row;
    }

    return $triangle;
}

$triangle = generatePascalTriangle(5);
foreach ($triangle as $row) {
    echo implode(' ', $row) . "\n";
}
