<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (!$username) $errors[] = "Username is required.";
    if (!$email) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (empty($errors)) {
        echo "<p style='color:green;'>Registration successful for $username.</p>";
        // Save to DB logic would go here
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
</head>
<body>

<h2>User Registration</h2>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">
    <label>Username:<br><input type="text" name="username"></label><br>
    <label>Email:<br><input type="email" name="email"></label><br>
    <label>Password:<br><input type="password" name="password"></label><br>
    <label>Confirm Password:<br><input type="password" name="confirm"></label><br>
    <button type="submit">Register</button>
</form>

</body>
</html>
