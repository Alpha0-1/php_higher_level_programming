<?php
/**
 * Checks if two objects are exactly of the same class.
 * @param object $a First object.
 * @param object $b Second object.
 * @return bool True if same class.
 */
function is_same_class($a, $b) {
    return get_class($a) === get_class($b);
}

// Example usage:
class A {}
class B {}

$a1 = new A();
$a2 = new A();
$b = new B();

var_dump(is_same_class($a1, $a2)); // true
var_dump(is_same_class($a1, $b));  // false
?>
