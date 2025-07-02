<?php
/**
 * Defines a Student class with basic properties.
 *
 * Usage: php 9-student.php
 */

class Student {
    public $name;
    public $age;
    public $grade;

    public function __construct($name, $age, $grade) {
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
    }

    public function display() {
        echo "$this->name | Age: $this->age | Grade: $this->grade\n";
    }
}

// Example usage
$student = new Student("John", 20, "A");
$student->display();
