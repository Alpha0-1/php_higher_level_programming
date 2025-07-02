<?php
/**
 * 0-safe_print_array.php - Safely print array contents using try/catch.
 *
 * Demonstrates how to catch errors when printing arrays that may not exist.
 */

function safePrintArray($arrayName) {
    try {
        if (!is_array($arrayName)) {
            throw new Exception("Provided variable is not an array.");
        }
        foreach ($arrayName as $item) {
            echo $item . "\n";
        }
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage() . "\n";
    }
}

// Example usage
$fruits = ["apple", "banana", "cherry"];
safePrintArray($fruits); // Should print all fruits
safePrintArray("not an array"); // Should trigger exception
