<?php
/**
 * Adds an attribute dynamically to an object.
 * @param object $obj Target object.
 * @param string $attrName Attribute name.
 * @param mixed $value Attribute value.
 */
function add_attribute(&$obj, $attrName, $value) {
    $obj->$attrName = $value;
}

// Example usage:
class TestClass {}

$obj = new TestClass();
add_attribute($obj, 'newAttr', 'Hello World');

echo $obj->newAttr; // Output: Hello World
?>
