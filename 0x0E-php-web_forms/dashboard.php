<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: 8-login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to your Dashboard</h2>
    <p>You are logged in successfully.</p>
    <a href="logout.php"><button>Logout</button></a>
</body>
</html>
