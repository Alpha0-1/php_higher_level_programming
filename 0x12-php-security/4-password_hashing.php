<?php
/**
 * Secure password hashing and verification
 */

// 1. Creating a password hash
function createPasswordHash($password) {
    // Use PASSWORD_ARGON2ID if available (PHP 7.3+), otherwise PASSWORD_BCRYPT
    $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
    
    $options = $algo === PASSWORD_BCRYPT 
        ? ['cost' => 12] 
        : [
            'memory_cost' => 65536,
            'time_cost' => 4,
            'threads' => 3
        ];
    
    return password_hash($password, $algo, $options);
}

// 2. Verifying a password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// 3. Checking if a hash needs rehashing
function needsRehash($hash) {
    $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
    return password_needs_rehash($hash, $algo);
}

// Example usage
$userPassword = 'SecurePassword123!';

// When creating/updating a password
$passwordHash = createPasswordHash($userPassword);
echo "Password hash: $passwordHash<br>";

// When verifying a password
$isValid = verifyPassword($userPassword, $passwordHash);
echo $isValid ? "Password is valid!" : "Invalid password!";

// Check if hash needs updating (e.g., if algorithm parameters changed)
if (needsRehash($passwordHash)) {
    $newHash = createPasswordHash($userPassword);
    // Update the hash in your database
    echo "<br>Password hash was updated to more secure version";
}

// Important notes:
// - Never use md5(), sha1(), or other fast hashing algorithms for passwords
// - The password_hash() function automatically generates a secure salt
// - Always store the complete hash (it includes algorithm, cost factor, and salt)
?>
