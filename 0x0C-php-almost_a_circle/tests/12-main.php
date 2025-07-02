<?php
require_once 'models/Square.php';

try {
    $square = new Square(-5);
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
