<?php
/**
 * 101-safe_function.php - Execute a function safely.
 *
 * Wraps function execution in a try/catch block.
 */

function executeSafely(callable $func, ...$args) {
    try {
        return call_user_func_array($func, $args);
    } catch (Exception $e) {
        echo "Function error: " . $e->getMessage() . "\n";
        return null;
    }
}

// Example usage
$result = executeSafely(function ($a, $b) {
    if ($b == 0) throw new Exception("Division by zero");
    return $a / $b;
}, 10, 0);

echo $result === null ? "Operation failed\n" : "Result: $result\n";
