<?php
require_once 'models/Rectangle.php';

try {
    $r = new Rectangle(10, 20);
    echo "Rectangle ID: " . $r->getId() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
