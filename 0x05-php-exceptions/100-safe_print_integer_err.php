<?php
/**
 * 100-safe_print_integer_err.php - Safe print integer with error logging.
 *
 * Logs invalid attempts to a file instead of just displaying them.
 */

function safePrintIntegerWithErrorLog($value) {
    try {
        if (!is_int($value)) {
            throw new Exception("Invalid type provided: " . gettype($value));
        }
        echo $value . "\n";
    } catch (Exception $e) {
        error_log("Integer print error: " . $e->getMessage());
        echo "An error occurred while printing.\n";
    }
}

// Example usage
safePrintIntegerWithErrorLog(100);     // Prints 100
safePrintIntegerWithErrorLog("100");   // Logs error
