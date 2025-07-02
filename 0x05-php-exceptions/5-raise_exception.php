<?php
/**
 * 5-raise_exception.php - Raise a custom exception.
 *
 * Demonstrates throwing an exception without a message.
 */

class MyCustomException extends Exception {}

try {
    throw new MyCustomException();
} catch (MyCustomException $e) {
    echo "Caught a custom exception.\n";
}
