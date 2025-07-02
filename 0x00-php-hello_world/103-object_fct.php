<?php

/**
 * 103-object_fct.php
 *
 * Demonstrates object-oriented programming in PHP by defining a class
 * with a method that modifies its internal state.
 *
 * Usage:
 *   Create an instance of the Incrementer class and call increment()
 *   multiple times to observe how object state persists.
 */

/**
 * A class that holds a numeric value and provides a method to increment it.
 */
class Incrementer {
    private int $value;

    /**
     * Constructor initializes the value to 0.
     */
    public function __construct() {
        $this->value = 0;
    }

    /**
     * Increments the internal value by 1 and returns the new value.
     *
     * @return int The updated value after incrementing.
     */
    public function increment(): int {
        $this->value++;
        return $this->value;
    }
}

// Example usage
$obj = new Incrementer();
echo $obj->increment() . PHP_EOL; // Output: 1
echo $obj->increment() . PHP_EOL; // Output: 2
echo $obj->increment() . PHP_EOL; // Output: 3
