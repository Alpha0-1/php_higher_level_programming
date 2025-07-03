<?php
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Dummy credentials check
    if ($email === 'user@example.com' && $password === 'password123') {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
</head>
<body>

<h2>Login</h2>

<?php if ($message): ?>
    <p style="color:red;"><?= $message ?></p>
<?php endif; ?>

<form method="post">
    <label>Email:<br><input type="email" name="email"></label><br>
    <label>Password:<br><input type="password" name="password"></label><br>
    <button type="submit">Login</button>
</form>

</body>
</html>
