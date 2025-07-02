<!-- includes/functions.php -->
<?php
/**
 * Utility Functions
 * Common helper functions
 * @author Your Name
 * @license MIT
 */

require_once 'config.php';

/**
 * Format a message with application name
 * @param string $message Message to format
 * @return string Formatted message
 */
function formatMessage($message) {
    return APP_NAME . ": " . $message;
}

/**
 * Validate dimension against maximum allowed
 * @param int $dimension Dimension to check
 * @return bool
 */
function isValidDimension($dimension) {
    return is_int($dimension) && $dimension > 0 && $dimension <= MAX_DIMENSION;
}
