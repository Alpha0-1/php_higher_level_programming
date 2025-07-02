<?php
require_once 'models/Square.php';

try {
    $s1 = new Square(5);
    $s2 = new Square(6);

    echo "Square 1 ID: " . $s1->getId() . "\n"; // Should be 1
    echo "Square 2 ID: " . $s2->getId() . "\n"; // Should be 2
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
