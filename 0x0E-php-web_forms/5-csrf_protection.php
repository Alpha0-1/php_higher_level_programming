<?php
session_start();

function generateCsrfToken() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid or missing CSRF token.");
    }
    echo "<p style='color:green;'>Form submitted securely!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Protection</title>
</head>
<body>

<h2>CSRF Protected Form</h2>

<form method="post">
    <label>Name:<br><input type="text" name="name"></label><br>
    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
    <button type="submit">Submit</button>
</form>

</body>
</html>
