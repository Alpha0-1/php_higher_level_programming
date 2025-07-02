<?php
require_once 'models/Square.php';

try {
    $s1 = new Square(2);
    $s2 = new Square(3);
    $s3 = new Square(4);

    echo "Square 1 ID: " . $s1->getId() . "\n";
    echo "Square 2 ID: " . $s2->getId() . "\n";
    echo "Square 3 ID: " . $s3->getId() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
