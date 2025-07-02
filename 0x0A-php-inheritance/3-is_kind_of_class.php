<?php
/**
 * Checks if object is of the given class or its subclass.
 * @param object $obj Object to check.
 * @param string $className Name of the class.
 * @return bool True if instance of or subclass.
 */
function is_kind_of_class($obj, $className) {
    return $obj instanceof $className;
}

// Example usage:
class Animal {}
class Dog extends Animal {}

$animal = new Animal();
$dog = new Dog();

var_dump(is_kind_of_class($animal, 'Animal')); // true
var_dump(is_kind_of_class($dog, 'Animal'));    // true
var_dump(is_kind_of_class($animal, 'Dog'));    // false
?>
