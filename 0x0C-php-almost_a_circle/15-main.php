<?php
require_once 'models/Square.php';

try {
    $square = new Square("five");
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
