<?php
/**
 * Input validation in PHP
 * Demonstrates various techniques to validate user input
 */

// 1. Validating a required field
function validateRequired($input) {
    if (empty(trim($input))) {
        throw new InvalidArgumentException("This field is required");
    }
    return $input;
}

// 2. Validating email format
function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Invalid email format");
    }
    return $email;
}

// 3. Validating numeric range
function validateNumberRange($number, $min, $max) {
    if (!is_numeric($number) || $number < $min || $number > $max) {
        throw new InvalidArgumentException("Number must be between $min and $max");
    }
    return $number;
}

// 4. Sanitizing string input
function sanitizeString($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Example usage:
try {
    $username = sanitizeString($_POST['username'] ?? '');
    validateRequired($username);
    
    $email = $_POST['email'] ?? '';
    validateEmail($email);
    
    $age = $_POST['age'] ?? 0;
    validateNumberRange($age, 18, 120);
    
    echo "All inputs are valid!";
} catch (InvalidArgumentException $e) {
    echo "Validation error: " . $e->getMessage();
}
?>
