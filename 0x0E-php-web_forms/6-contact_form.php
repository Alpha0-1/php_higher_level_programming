<?php
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = trim($_POST['message']);

    if (!$name) $errors[] = "Name is required.";
    if (!$email) $errors[] = "Valid email is required.";
    if (!$message) $errors[] = "Message is required.";

    if (empty($errors)) {
        $to = "admin@example.com";
        $subject = "New Contact Message from $name";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        mail($to, $subject, $message, $headers);
        $success = "Thank you! Your message has been sent.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
</head>
<body>

<h2>Contact Us</h2>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="post">
    <label>Name:<br><input type="text" name="name"></label><br>
    <label>Email:<br><input type="email" name="email"></label><br>
    <label>Message:<br><textarea name="message"></textarea></label><br>
    <button type="submit">Send Message</button>
</form>

</body>
</html>
