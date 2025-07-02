<?php
/**
 * Serializes a class instance into a JSON string.
 *
 * Usage: php 8-class_to_json.php
 */

class Car {
    public $make;
    public $model;
    public $year;

    public function __construct($make, $model, $year) {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }
}

$myCar = new Car("Toyota", "Corolla", 2020);
$json = json_encode($myCar, JSON_PRETTY_PRINT);

echo "Class to JSON:\n" . $json . "\n";
