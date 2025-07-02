<?php
/**
 * 0-lookup.php - Returns a list of all attributes and methods of an object.
 *
 * @param object $obj The object to inspect.
 * @return array List of attributes and methods.
 */
function lookup($obj) {
    return get_class_methods(get_class($obj));
}

// Example usage:
class SampleClass {
    public function sayHello() { echo "Hello"; }
    private function secret() { echo "Secret"; }
}

$obj = new SampleClass();
print_r(lookup($obj));
?>
