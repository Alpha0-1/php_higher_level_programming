<?php
/**
 * 100-let_me_const.php - Constants Manipulation
 * 
 * This script demonstrates PHP constants usage, definition, and manipulation.
 * Shows different types of constants and their practical applications.
 * 
 * Learning objectives:
 * - Constant definition with define() and const
 * - Magic constants
 * - Class constants
 * - Constant arrays
 * - Constant checking functions
 * 
 * Usage: php 100-let_me_const.php
 */

// Define constants using define() function
define('GREETING', 'Hello, World!');
define('PI', 3.14159);
define('MAX_USERS', 1000);
define('DEBUG_MODE', true);

// Define constant array (PHP 7.0+)
define('SUPPORTED_LANGUAGES', ['PHP', 'JavaScript', 'Python', 'Java']);

// Class with constants
class MathConstants {
    const E = 2.71828;
    const GOLDEN_RATIO = 1.618;
    const EULER_MASCHERONI = 0.5772;
    
    public static function getAllConstants() {
        $reflection = new ReflectionClass(self::class);
        return $reflection->getConstants();
    }
}

// Another class demonstrating constant usage
class Configuration {
    const VERSION = '1.0.0';
    const AUTHOR = 'PHP Developer';
    const DATABASE_HOST = 'localhost';
    const DATABASE_PORT = 3306;
    
    // Class constants can be used in other constants
    const FULL_VERSION = self::VERSION . '-stable';
}

/**
 * Demonstrate basic constant usage
 */
function demonstrateBasicConstants() {
    echo "Basic Constants Demonstration:\n";
    echo "=============================\n";
    
    echo "GREETING: " . GREETING . "\n";
    echo "PI: " . PI . "\n";
    echo "MAX_USERS: " . MAX_USERS . "\n";
    echo "DEBUG_MODE: " . (DEBUG_MODE ? 'true' : 'false') . "\n";
    
    echo "SUPPORTED_LANGUAGES: " . implode(', ', SUPPORTED_LANGUAGES) . "\n\n";
}

/**
 * Demonstrate magic constants
 */
function demonstrateMagicConstants() {
    echo "Magic Constants:\n";
    echo "===============\n";
    
    echo "__FILE__: " . __FILE__ . "\n";
    echo "__DIR__: " . __DIR__ . "\n";
    echo "__LINE__: " . __LINE__ . "\n";
    echo "__FUNCTION__: " . __FUNCTION__ . "\n";
    echo "__CLASS__: " . __CLASS__ . "\n";
    echo "__METHOD__: " . __METHOD__ . "\n";
    echo "PHP_VERSION: " . PHP_VERSION . "\n";
    echo "PHP_OS: " . PHP_OS . "\n\n";
}

/**
 * Demonstrate class constants
 */
function demonstrateClassConstants() {
    echo "Class Constants:\n";
    echo "===============\n";
    
    echo "MathConstants::E: " . MathConstants::E . "\n";
    echo "MathConstants::GOLDEN_RATIO: " . MathConstants::GOLDEN_RATIO . "\n";
    
    echo "\nAll Math Constants:\n";
    $constants = MathConstants::getAllConstants();
    foreach ($constants as $name => $value) {
        echo "  $name: $value\n";
    }
    
    echo "\nConfiguration Constants:\n";
    echo "  VERSION: " . Configuration::VERSION . "\n";
    echo "  AUTHOR: " . Configuration::AUTHOR . "\n";
    echo "  FULL_VERSION: " . Configuration::FULL_VERSION . "\n";
    echo "  DATABASE: " . Configuration::DATABASE_HOST . ":" . Configuration::DATABASE_PORT . "\n\n";
}

/**
 * Demonstrate constant checking and manipulation
 */
function demonstrateConstantChecking() {
    echo "Constant Checking and Information:\n";
    echo "=================================\n";
    
    // Check if constant exists
    echo "GREETING exists: " . (defined('GREETING') ? 'Yes' : 'No') . "\n";
    echo "NONEXISTENT exists: " . (defined('NONEXISTENT') ? 'Yes' : 'No') . "\n";
    
    // Get constant value dynamically
    $constantName = 'PI';
    if (defined($constantName)) {
        echo "Value of $constantName: " . constant($constantName) . "\n";
    }
    
    // Get all defined constants
    echo "\nUser-defined constants in this script:\n";
    $allConstants = get_defined_constants(true);
    $userConstants = $allConstants['user'];
    
    foreach ($userConstants as $name => $value) {
        if (is_array($value)) {
            echo "  $name: [" . implode(', ', $value) . "]\n";
        } else {
            echo "  $name: $value\n";
        }
    }
    echo "\n";
}

/**
 * Practical example using constants
 */
function practicalExample() {
    echo "Practical Example - Application Settings:\n";
    echo "========================================\n";
    
    // Application constants
    define('APP_NAME', 'My PHP Application');
    define('APP_VERSION', '2.1.0');
    define('MAX_LOGIN_ATTEMPTS', 3);
    define('SESSION_TIMEOUT', 3600); // 1 hour in seconds
    define('ALLOWED_FILE_TYPES', ['jpg', 'png', 'gif', 'pdf']);
    
    echo "Application: " . APP_NAME . " v" . APP_VERSION . "\n";
    echo "Security Settings:\n";
    echo "  Max login attempts: " . MAX_LOGIN_ATTEMPTS . "\n";
    echo "  Session timeout: " . (SESSION_TIMEOUT / 60) . " minutes\n";
    echo "  Allowed file types: " . implode(', ', ALLOWED_FILE_TYPES) . "\n";
    
    // Simulate checking file type
    $uploadedFile = 'document.pdf';
    $extension = pathinfo($uploadedFile, PATHINFO_EXTENSION);
    
    if (in_array($extension, ALLOWED_FILE_TYPES)) {
        echo "File '$uploadedFile' is allowed\n";
    } else {
        echo "File '$uploadedFile' is not allowed\n";
    }
    
    echo "\n";
}

/**
 * Constants vs Variables comparison
 */
function constantsVsVariables() {
    echo "Constants vs Variables:\n";
    echo "======================\n";
    
    // Variable
    $variable = "I can change";
    echo "Variable initial: $variable\n";
    $variable = "I have changed";
    echo "Variable after change: $variable\n";
    
    // Constant
    define('IMMUTABLE', 'I cannot change');
    echo "Constant: " . IMMUTABLE . "\n";
    
    // Try to redefine (this will generate a notice)
    if (!defined('IMMUTABLE_TEST')) {
        define('IMMUTABLE_TEST', 'Original value');
        echo "IMMUTABLE_TEST defined: " . IMMUTABLE_TEST . "\n";
        
        // This will fail silently or generate a warning
        define('IMMUTABLE_TEST', 'New value');
        echo "IMMUTABLE_TEST after redefinition attempt: " . IMMUTABLE_TEST . "\n";
    }
    
    echo "\n";
}

// Execute all demonstrations
demonstrateBasicConstants();
demonstrateMagicConstants();
demonstrateClassConstants();
demonstrateConstantChecking();
practicalExample();
constantsVsVariables();

// Performance comparison
echo "Performance Comparison:\n";
echo "======================\n";

$iterations = 100000;

// Test variable access
$start = microtime(true);
$testVar = "test value";
for ($i = 0; $i < $iterations; $i++) {
    $temp = $testVar;
}
$varTime = microtime(true) - $start;

// Test constant access
define('TEST_CONST', 'test value');
$start = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $temp = TEST_CONST;
}
$constTime = microtime(true) - $start;

echo "Variable access ($iterations iterations): " . number_format($varTime * 1000, 4) . " ms\n";
echo "Constant access ($iterations iterations): " . number_format($constTime * 1000, 4) . " ms\n";
echo "Constants are " . number_format($constTime / $varTime, 2) . "x " . 
     ($constTime > $varTime ? "slower" : "faster") . " than variables\n";
?>

