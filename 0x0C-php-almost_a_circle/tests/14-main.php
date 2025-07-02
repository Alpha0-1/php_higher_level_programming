<?php
require_once 'models/Rectangle.php';

try {
    $rect = new Rectangle(5, "ten");
} catch (Exception $e) {
    echo "Expected error: " . $e->getMessage() . "\n";
}
?>
