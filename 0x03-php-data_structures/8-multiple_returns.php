<?php
/**
 * 8-multiple_returns.php
 *
 * This script demonstrates returning multiple values using an associative array.
 */

function getUserInfo() {
    $name = "Alice";
    $age = 30;
    $email = "alice@example.com";

    return compact('name', 'age', 'email');
}

// Example usage
$info = getUserInfo();

echo "Name: " . $info['name'] . PHP_EOL;
echo "Age: " . $info['age'] . PHP_EOL;
echo "Email: " . $info['email'] . PHP_EOL;

/**
 * Output:
 * Name: Alice
 * Age: 30
 * Email: alice@example.com
 */
?>
