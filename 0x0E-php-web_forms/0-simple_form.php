<?php
/**
 * 0-simple_form.php - Basic Form Processing
 * 
 * This file demonstrates fundamental form processing in PHP.
 * It shows how to handle GET and POST requests, sanitize input,
 * and provide feedback to users.
 * 
 * Learning objectives:
 * - Understanding $_GET and $_POST superglobals
 * - Basic input sanitization
 * - Simple form validation
 * - Displaying form data
 * 
 * @author  Alpha0-1
 * @version 1.0
 */

// Initialize variables to avoid undefined variable warnings
$name = $email = $message = '';
$errors = [];
$success = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Basic validation
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        $success = true;
        // Here you would typically save to database, send email, etc.
        // For this example, we'll just show success message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form Processing</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], textarea { 
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; 
        }
        textarea { height: 100px; resize: vertical; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #005a87; }
        .error { color: #d32f2f; margin-top: 5px; }
        .success { color: #388e3c; padding: 10px; background: #e8f5e8; border-radius: 4px; margin-bottom: 20px; }
        .errors { color: #d32f2f; padding: 10px; background: #fdeaea; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Simple Form Processing Example</h1>
    
    <?php if ($success): ?>
        <div class="success">
            <h3>Form submitted successfully!</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Message:</strong> <?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <h3>Please fix the following errors:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required><?php echo htmlspecialchars($message); ?></textarea>
        </div>
        
        <button type="submit">Submit Form</button>
    </form>
    
    <div style="margin-top: 30px; padding: 15px; background: #f5f5f5; border-radius: 4px;">
        <h3>Learning Notes:</h3>
        <ul>
            <li><strong>$_SERVER['REQUEST_METHOD']:</strong> Checks if form was submitted via POST</li>
            <li><strong>htmlspecialchars():</strong> Prevents XSS attacks by encoding HTML characters</li>
            <li><strong>filter_var():</strong> Validates email format using built-in PHP filters</li>
            <li><strong>trim():</strong> Removes whitespace from beginning and end of strings</li>
            <li><strong>Null coalescing operator (??):</strong> Provides default value if key doesn't exist</li>
        </ul>
    </div>
</body>
</html>
