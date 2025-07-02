<?php
/**
 * 12-array.php - Array Manipulation Techniques
 * 
 * This script demonstrates comprehensive array operations including
 * creation, modification, searching, and transformation techniques.
 * 
 * Learning objectives:
 * - Array creation methods
 * - Array manipulation functions
 * - Associative vs indexed arrays
 * - Array searching and filtering
 * - Array transformation
 * 
 * Usage: php 12-array.php
 */

/**
 * Demonstrate basic array operations
 */
function basicArrayOperations() {
    echo "Basic Array Operations:\n";
    echo "======================\n";
    
    // Array creation methods
    $fruits = ["apple", "banana", "cherry", "date"];
    $numbers = range(1, 10);
    $mixed = [1, "hello", 3.14, true];
    
    echo "Fruits array: " . implode(", ", $fruits) . "\n";
    echo "Numbers array: " . implode(", ", $numbers) . "\n";
    echo "Mixed array: " . implode(", ", array_map('var_export', $mixed, array_fill(0, count($mixed), true))) . "\n\n";
    
    // Array properties
    echo "Array Properties:\n";
    echo "Count of fruits: " . count($fruits) . "\n";
    echo "First fruit: " . $fruits[0] . "\n";
    echo "Last fruit: " . end($fruits) . "\n";
    echo "Array keys: " . implode(", ", array_keys($fruits)) . "\n\n";
}

/**
 * Demonstrate associative array operations
 */
function associativeArrayOperations() {
    echo "Associative Array Operations:\n";
    echo "============================\n";
    
    $student = [
        "name" => "John Doe",
        "age" => 20,
        "grade" => "A",
        "subjects" => ["Math", "Physics", "Chemistry"]
    ];
    
    echo "Student Information:\n";
    foreach ($student as $key => $value) {
        if (is_array($value)) {
            echo "  $key: " . implode(", ", $value) . "\n";
        } else {
            echo "  $key: $value\n";
        }
    }
    
    // Adding new elements
    $student["email"] = "john.doe@email.com";
    $student["gpa"] = 3.8;
    
    echo "\nAfter adding email and GPA:\n";
    echo "  Email: " . $student["email"] . "\n";
    echo "  GPA: " . $student["gpa"] . "\n\n";
}

/**
 * Demonstrate array searching and filtering
 */
function arraySearchAndFilter() {
    echo "Array Searching and Filtering:\n";
    echo "==============================\n";
    
    $numbers = [10, 25, 5, 30, 15, 40, 8, 22];
    
    echo "Original array: " . implode(", ", $numbers) . "\n";
    
    // Searching
    $searchValue = 25;
    $key = array_search($searchValue, $numbers);
    echo "Position of $searchValue: " . ($key !== false ? $key : "not found") . "\n";
    
    // Check if value exists
    echo "Does 30 exist? " . (in_array(30, $numbers) ? "Yes" : "No") . "\n";
    
    // Filtering
    $evenNumbers = array_filter($numbers, function($n) {
        return $n % 2 == 0;
    });
    echo "Even numbers: " . implode(", ", $evenNumbers) . "\n";
    
    $largeNumbers = array_filter($numbers, function($n) {
        return $n > 20;
    });
    echo "Numbers > 20: " . implode(", ", $largeNumbers) . "\n";
    
    // Finding min, max, sum
    echo "Minimum: " . min($numbers) . "\n";
    echo "Maximum: " . max($numbers) . "\n";
    echo "Sum: " . array_sum($numbers) . "\n";
    echo "Average: " . (array_sum($numbers) / count($numbers)) . "\n\n";
}

/**
 * Demonstrate array transformation
 */
function arrayTransformation() {
    echo "Array Transformation:\n";
    echo "====================\n";
    
    $numbers = [1, 2, 3, 4, 5];
    
    // Map - transform each element
    $squared = array_map(function($n) {
        return $n * $n;
    }, $numbers);
    echo "Original: " . implode(", ", $numbers) . "\n";
    echo "Squared: " . implode(", ", $squared) . "\n";
    
    // Reduce - combine all elements
    $sum = array_reduce($numbers, function($carry, $item) {
        return $carry + $item;
    }, 0);
    echo "Sum using reduce: $sum\n";
    
    $product = array_reduce($numbers, function($carry, $item) {
        return $carry * $item;
    }, 1);
    echo "Product using reduce: $product\n";
    
    // Sorting
    $randomNumbers = [64, 34, 25, 12, 22, 11, 90];
    echo "\nSorting Examples:\n";
    echo "Original: " . implode(", ", $randomNumbers) . "\n";
    
    $ascending = $randomNumbers;
    sort($ascending);
    echo "Ascending: " . implode(", ", $ascending) . "\n";
    
    $descending = $randomNumbers;
    rsort($descending);
    echo "Descending: " . implode(", ", $descending) . "\n\n";
}

/**
 * Demonstrate multidimensional arrays
 */
function multidimensionalArrays() {
    echo "Multidimensional Arrays:\n";
    echo "=======================\n";
    
    $students = [
        ["name" => "Alice", "age" => 20, "grade" => 85],
        ["name" => "Bob", "age" => 22, "grade" => 92],
        ["name" => "Charlie", "age" => 19, "grade" => 78],
        ["name" => "Diana", "age" => 21, "grade" => 95]
    ];
    
    echo "Students Data:\n";
    foreach ($students as $index => $student) {
        echo ($index + 1) . ". {$student['name']} (Age: {$student['age']}, Grade: {$student['grade']})\n";
    }
    
    // Extract specific column
    $names = array_column($students, 'name');
    echo "\nStudent names: " . implode(", ", $names) . "\n";
    
    $grades = array_column($students, 'grade');
    echo "Average grade: " . (array_sum($grades) / count($grades)) . "\n";
    
    // Sort by grade
    usort($students, function($a, $b) {
        return $b['grade'] - $a['grade'];
    });
    
    echo "\nStudents sorted by grade (highest first):\n";
    foreach ($students as $index => $student) {
        echo ($index + 1) . ". {$student['name']} - {$student['grade']}\n";
    }
    echo "\n";
}

// Execute all demonstrations
basicArrayOperations();
associativeArrayOperations();
arraySearchAndFilter();
arrayTransformation();
multidimensionalArrays();

// Interactive section
echo "Interactive Array Operations:\n";
echo "============================\n";

// Create array from command line arguments if provided
if ($argc > 1) {
    $userNumbers = array_slice($argv, 1);
    $validNumbers = array_filter($userNumbers, 'is_numeric');
    
    if (!empty($validNumbers)) {
        $validNumbers = array_map('floatval', $validNumbers);
        echo "Your numbers: " . implode(", ", $validNumbers) . "\n";
        echo "Sum: " . array_sum($validNumbers) . "\n";
        echo "Average: " . (array_sum($validNumbers) / count($validNumbers)) . "\n";
        echo "Min: " . min($validNumbers) . "\n";
        echo "Max: " . max($validNumbers) . "\n";
        
        sort($validNumbers);
        echo "Sorted: " . implode(", ", $validNumbers) . "\n";
    }
}
?>

