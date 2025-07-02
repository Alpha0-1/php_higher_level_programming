<?php
/**
 * 101-call_me_moby.php - Function Execution and Callbacks
 * 
 * This script demonstrates function execution, callbacks, and higher-order
 * functions in PHP. Shows how functions can be passed as parameters.
 * 
 * Learning objectives:
 * - Function callbacks
 * - Higher-order functions
 * - Anonymous functions (closures)
 * - Variable functions
 * - Function references
 * 
 * Usage: php 101-call_me_moby.php
 */

/**
 * Execute a function a specified number of times
 * 
 * @param callable $callback The function to execute
 * @param int $times Number of times to execute
 * @param mixed ...$args Arguments to pass to the callback
 */
function callMeMoby($callback, $times, ...$args) {
    if (!is_callable($callback)) {
        echo "Error: First parameter must be callable\n";
        return;
    }
    
    if (!is_numeric($times) || $times < 0) {
        echo "Error: Times must be a non-negative number\n";
        return;
    }
    
    echo "Executing function $times times:\n";
    for ($i = 1; $i <= $times; $i++) {
        echo "Call $i: ";
        call_user_func_array($callback, $args);
    }
    echo "\n";
}

/**
 * Simple greeting function
 */
function sayHello($name = "World") {
    echo "Hello, $name!\n";
}

/**
 * Mathematical operation function
 */
function calculate($operation, $a, $b) {
    switch ($operation) {
        case 'add':
            echo "$a + $b = " . ($a + $b) . "\n";
            break;
        case 'multiply':
            echo "$a × $b = " . ($a * $b) . "\n";
            break;
        case 'subtract':
            echo "$a - $b = " . ($a - $b) . "\n";
            break;
        default:
            echo "Unknown operation: $operation\n";
    }
}

/**
 * Function that returns a closure
 */
function createCounter($start = 0) {
    return function() use (&$start) {
        return ++$start;
    };
}

/**
 * Function that accepts and uses callbacks
 */
function processArray($array, $callback) {
    echo "Processing array with callback:\n";
    foreach ($array as $item) {
        $callback($item);
    }
    echo "\n";
}

/**
 * Demonstrate basic function calling
 */
function demonstrateBasicCalling() {
    echo "Basic Function Calling:\n";
    echo "======================\n";
    
    // Call function multiple times
    callMeMoby('sayHello', 3);
    
    // Call with parameters
    callMeMoby('sayHello', 2, 'PHP Developer');
    
    // Call mathematical function
    callMeMoby('calculate', 3, 'add', 10, 5);
}

/**
 * Demonstrate anonymous functions
 */
function demonstrateAnonymousFunctions() {
    echo "Anonymous Functions (Closures):\n";
    echo "==============================\n";
    
    // Simple anonymous function
    $greet = function($name) {
        echo "Greetings, $name!\n";
    };
    
    callMeMoby($greet, 2, 'Anonymous Function');
    
    // Anonymous function with use clause
    $multiplier = 3;
    $multiply = function($number) use ($multiplier) {
        echo "$number × $multiplier = " . ($number * $multiplier) . "\n";
    };
    
    callMeMoby($multiply, 3, 5);
    
    // Closure that modifies external variable
    $counter = createCounter(10);
    echo "Counter starting at 10:\n";
    for ($i = 0; $i < 5; $i++) {
        echo "Count: " . $counter() . "\n";
    }
    echo "\n";
}

/**
 * Demonstrate array callbacks
 */
function demonstrateArrayCallbacks() {
    echo "Array and Object Callbacks:\n";
    echo "===========================\n";
    
    $numbers = [1, 2, 3, 4, 5];
    
    // Using array_map with callback
    echo "Original numbers: " . implode(', ', $numbers) . "\n";
    
    $squared = array_map(function($n) {
        return $n * $n;
    }, $numbers);
    echo "Squared: " . implode(', ', $squared) . "\n";
    
    // Custom array processing
    processArray($numbers, function($item) {
        echo "Processing item: $item (doubled: " . ($item * 2) . ")\n";
    });
}

/**
 * Class for demonstrating object method callbacks
 */
class Calculator {
    private $name;
    
    public function __construct($name = "Calculator") {
        $this->name = $name;
    }
    
    public function add($a, $b) {
        echo "{$this->name}: $a + $b = " . ($a + $b) . "\n";
    }
    
    public function multiply($a, $b) {
        echo "{$this->name}: $a × $b = " . ($a * $b) . "\n";
    }
    
    public function describe() {
        echo "I am {$this->name}\n";
    }
}

/**
 * Demonstrate object method callbacks
 */
function demonstrateObjectCallbacks() {
    echo "Object Method Callbacks:\n";
    echo "=======================\n";
    
    $calc = new Calculator("Advanced Calculator");
    
    // Method callback
    callMeMoby([$calc, 'describe'], 2);
    callMeMoby([$calc, 'add'], 3, 15, 25);
    
    // Static method callback (if we had static methods)
    echo "\n";
}

/**
 * Advanced callback examples
 */
function demonstrateAdvancedCallbacks() {
    echo "Advanced Callback Examples:\n";
    echo "==========================\n";
    
    // Function composition
    $addOne = function($x) { return $x + 1; };
    $double = function($x) { return $x * 2; };
    
    $compose = function($f, $g) {
        return function($x) use ($f, $g) {
            return $f($g($x));
        };
    };
    
    $addOneThenDouble = $compose($double, $addOne);
    echo "Composing functions: (5 + 1) × 2 = " . $addOneThenDouble(5) . "\n";
    
    // Event-like callback system
    $events = [];
    
    $addEventListener = function($event, $callback) use (&$events) {
        if (!isset($events[$event])) {
            $events[$event] = [];
        }
        $events[$event][] = $callback;
    };
    
    $triggerEvent = function($event, ...$args) use (&$events) {
        if (isset($events[$event])) {
            echo "Triggering event: $event\n";
            foreach ($events[$event] as $callback) {
                $callback(...$args);
            }
        }
    };
    
    // Add event listeners
    $addEventListener('user_login', function($username) {
        echo "  Welcome back, $username!\n";
    });
    
    $addEventListener('user_login', function($username) {
        echo "  Logging access for $username\n";
    });
    
    // Trigger event
    $triggerEvent('user_login', 'john_doe');
    
    echo "\n";
}

/**
 * Performance comparison of different callback methods
 */
function performanceComparison() {
    echo "Performance Comparison:\n";
    echo "======================\n";
    
    $iterations = 100000;
    
    // Direct function call
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        strlen("test");
    }
    $directTime = microtime(true) - $start;
    
    // Variable function call
    $func = 'strlen';
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        $func("test");
    }
    $variableTime = microtime(true) - $start;
    
    // call_user_func
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        call_user_func('strlen', "test");
    }
    $callUserFuncTime = microtime(true) - $start;
    
    // Anonymous function
    $anonymous = function($str) { return strlen($str); };
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        $anonymous("test");
    }
    $anonymousTime = microtime(true) - $start;
    
    echo "Performance test ($iterations iterations):\n";
    echo "  Direct call: " . number_format($directTime * 1000, 4) . " ms\n";
    echo "  Variable function: " . number_format($variableTime * 1000, 4) . " ms\n";
    echo "  call_user_func: " . number_format($callUserFuncTime * 1000, 4) . " ms\n";
    echo "  Anonymous function: " . number_format($anonymousTime * 1000, 4) . " ms\n";
    
    echo "\n";
}

// Execute all demonstrations
demonstrateBasicCalling();
demonstrateAnonymousFunctions();
demonstrateArrayCallbacks();
demonstrateObjectCallbacks();
demonstrateAdvancedCallbacks();
performanceComparison();

// Interactive example
if ($argc > 1) {
    echo "Interactive Example:\n";
    echo "===================\n";
    
    $times = isset($argv[1]) && is_numeric($argv[1]) ? (int)$argv[1] : 3;
    $message = isset($argv[2]) ? $argv[2] : "Command Line";
    
    echo "Calling with command line arguments:\n";
    callMeMoby(function($msg) {
        echo "Message: $msg\n";
    }, $times, $message);
}
?>

