<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle(4, 6);
    echo "Rectangle Area: " . $rect->area() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
