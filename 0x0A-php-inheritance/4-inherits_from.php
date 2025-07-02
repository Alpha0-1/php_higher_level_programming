<?php
/**
 * Checks if a class inherits from another class.
 * @param string $childClass Name of child class.
 * @param string $parentClass Name of parent class.
 * @return bool True if child inherits from parent.
 */
function inherits_from($childClass, $parentClass) {
    $reflection = new ReflectionClass($childClass);
    return $reflection->isSubclassOf($parentClass);
}

// Example usage:
class Vehicle {}
class Car extends Vehicle {}

var_dump(inherits_from('Car', 'Vehicle')); // true
var_dump(inherits_from('Vehicle', 'Car')); // false
?>
