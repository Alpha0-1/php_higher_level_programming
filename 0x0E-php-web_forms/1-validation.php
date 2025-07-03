<?php
/**
 * 1-validation.php - Advanced Form Validation
 * 
 * This file demonstrates comprehensive form validation techniques in PHP.
 * It covers various validation types, custom validation functions,
 * and proper error handling with user-friendly feedback.
 * 
 * Learning objectives:
 * - Server-side validation best practices
 * - Custom validation functions
 * - Regular expressions for validation
 * - Sanitization vs validation
 * - Error message handling
 * 
 * @author  Alpha0-1
 */

/**
 * Custom validation class for reusable validation methods
 */
class FormValidator 
{
    /**
     * Validate required field
     * 
     * @param string $value The value to validate
     * @param string $field_name The field name for error messages
     * @return string|null Error message or null if valid
     */
    public static function required($value, $field_name) 
    {
        if (empty(trim($value))) {
            return ucfirst($field_name) . ' is required';
        }
        return null;
    }
    
    /**
     * Validate email format
     * 
     * @param string $email The email to validate
     * @return string|null Error message or null if valid
     */
    public static function email($email) 
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address';
        }
        return null;
    }
    
    /**
     * Validate phone number (US format)
     * 
     * @param string $phone The phone number to validate
     * @return string|null Error message or null if valid
     */
    public static function phone($phone) 
    {
        $pattern = '/^[\+]?[1-9][\d]{0,15}$/';
        if (!preg_match($pattern, preg_replace('/[^\d+]/', '', $phone))) {
            return 'Please enter a valid phone number';
        }
        return null;
    }
    
    /**
     * Validate password strength
     * 
     * @param string $password The password to validate
     * @return string|null Error message or null if valid
     */
    public static function password($password) 
    {
        if (strlen($password) < 8) {
            return 'Password must be at least 8 characters long';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return 'Password must contain at least one uppercase letter';
        }
        if (!preg_match('/[a-z]/', $password)) {
            return 'Password must contain at least one lowercase letter';
        }
        if (!preg_match('/\d/', $password)) {
            return 'Password must contain at least one number';
        }
        return null;
    }
    
    /**
     * Validate age (must be 18 or older)
     * 
     * @param string $birthdate The birthdate in Y-m-d format
     * @return string|null Error message or null if valid
     */
    public static function age($birthdate) 
    {
        $date = DateTime::createFromFormat('Y-m-d', $birthdate);
        if (!$date) {
            return 'Please enter a valid birthdate';
        }
        
        $today = new DateTime();
        $age = $today->diff($date)->y;
        
        if ($age < 18) {
            return 'You must be at least 18 years old';
        }
        return null;
    }
    
    /**
     * Validate URL format
     * 
     * @param string $url The URL to validate
     * @return string|null Error message or null if valid
     */
    public static function url($url) 
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return 'Please enter a valid URL';
        }
        return null;
    }
}

// Initialize form data and errors
$form_data = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone' => '',
    'website' => '',
    'birthdate' => '',
    'password' => '',
    'confirm_password' => '',
    'terms' => false
];

$errors = [];
$success = false;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $form_data['first_name'] = trim($_POST['first_name'] ?? '');
    $form_data['last_name'] = trim($_POST['last_name'] ?? '');
    $form_data['email'] = trim($_POST['email'] ?? '');
    $form_data['phone'] = trim($_POST['phone'] ?? '');
    $form_data['website'] = trim($_POST['website'] ?? '');
    $form_data['birthdate'] = trim($_POST['birthdate'] ?? '');
    $form_data['password'] = $_POST['password'] ?? '';
    $form_data['confirm_password'] = $_POST['confirm_password'] ?? '';
    $form_data['terms'] = isset($_POST['terms']);
    
    // Validate each field
    if ($error = FormValidator::required($form_data['first_name'], 'first name')) {
        $errors['first_name'] = $error;
    }
    
    if ($error = FormValidator::required($form_data['last_name'], 'last name')) {
        $errors['last_name'] = $error;
    }
    
    if ($error = FormValidator::required($form_data['email'], 'email')) {
        $errors['email'] = $error;
    } elseif ($error = FormValidator::email($form_data['email'])) {
        $errors['email'] = $error;
    }
    
    if (!empty($form_data['phone']) && ($error = FormValidator::phone($form_data['phone']))) {
        $errors['phone'] = $error;
    }
    
    if (!empty($form_data['website']) && ($error = FormValidator::url($form_data['website']))) {
        $errors['website'] = $error;
    }
    
    if ($error = FormValidator::required($form_data['birthdate'], 'birthdate')) {
        $errors['birthdate'] = $error;
    } elseif ($error = FormValidator::age($form_data['birthdate'])) {
        $errors['birthdate'] = $error;
    }
    
    if ($error = FormValidator::required($form_data['password'], 'password')) {
        $errors['password'] = $error;
    } elseif ($error = FormValidator::password($form_data['password'])) {
        $errors['password'] = $error;
    }
    
    if ($form_data['password'] !== $form_data['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    if (!$form_data['terms']) {
        $errors['terms'] = 'You must accept the terms and conditions';
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        $success = true;
        // Clear sensitive data
        $form_data['password'] = '';
        $form_data['confirm_password'] = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Form Validation</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="tel"], input[type="url"], input[type="date"], input[type="password"] { 
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; 
        }
        .error-field { border-color: #d32f2f; }
        .success-field { border-color: #388e3c; }
        .error { color: #d32f2f; font-size: 14px; margin-top: 5px; }
        .success { color: #388e3c; padding: 15px; background: #e8f5e8; border-radius: 4px; margin-bottom: 20px; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        button { background: #007cba; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #005a87; }
        .validation-info { background: #f0f8ff; padding: 15px; border-radius: 4px; margin-top: 20px; }
        .validation-info h3 { margin-top: 0; }
    </style>
</head>
<body>
    <h1>Advanced Form Validation Example</h1>
    
    <?php if ($success): ?>
        <div class="success">
            <h3>Registration successful!</h3>
            <p>Welcome, <?php echo htmlspecialchars($form_data['first_name'] . ' ' . $form_data['last_name']); ?>!</p>
            <p>A confirmation email has been sent to <?php echo htmlspecialchars($form_data['email']); ?></p>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-row">
            <div class="form-group">
                <label for="first_name">First Name *</label>
                <input type="text" id="first_name" name="first_name" 
                       value="<?php echo htmlspecialchars($form_data['first_name']); ?>"
                       class="<?php echo isset($errors['first_name']) ? 'error-field' : ''; ?>" required>
                <?php if (isset($errors['first_name'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errors['first_name']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name *</label>
                <input type="text" id="last_name" name="last_name" 
                       value="<?php echo htmlspecialchars($form_data['last_name']); ?>"
                       class="<?php echo isset($errors['last_name']) ? 'error-field' : ''; ?>" required>
                <?php if (isset($errors['last_name'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errors['last_name']); ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($form_data['email']); ?>"
                   class="<?php echo isset($errors['email']) ? 'error-field' : ''; ?>" required>
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?php echo htmlspecialchars($errors['email']); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo htmlspecialchars($form_data['phone']); ?>"
                       class="<?php echo isset($errors['phone']) ? 'error-field' : ''; ?>" 
                       placeholder="e.g., +1234567890">
                <?php if (isset($errors['phone'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errors['phone']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" id="website" name="website" 
                       value="<?php echo htmlspecialchars($form_data['website']); ?>"
                       class="<?php echo isset($errors['website']) ? 'error-field' : ''; ?>" 
                       placeholder="https://example.com">
                <?php if (isset($errors['website'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errors['website']); ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-group">
            <label for="birthdate">Birth Date *</label>
            <input type="date" id="birthdate" name="birthdate" 
                   value="<?php echo htmlspecialchars($form_data['birthdate']); ?>"
                   class="<?php echo isset($errors['birthdate']) ? 'error-field' : ''; ?>" required>
            <?php if (isset($errors['birthdate'])): ?>
                <div class="error"><?php echo htmlspecialchars($errors['birthdate']); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" 
                       class="<?php echo isset($errors['password']) ? 'error-field' : ''; ?>" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errors['password']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" 
                       class="<?php echo isset($errors['confirm_password']) ? 'error-field' : ''; ?>" required>
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="error"><?php echo htmlspecialchars($errors['confirm_password']); ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" 
                       <?php echo $form_data['terms'] ? 'checked' : ''; ?> required>
                <label for="terms">I accept the Terms and Conditions *</label>
            </div>
            <?php if (isset($errors['terms'])): ?>
                <div class="error"><?php echo htmlspecialchars($errors['terms']); ?></div>
            <?php endif; ?>
        </div>
        
        <button type="submit">Create Account</button>
    </form>
    
    <div class="validation-info">
        <h3>Validation Features Demonstrated:</h3>
        <ul>
            <li><strong>Required Fields:</strong> First name, last name, email, birthdate, password</li>
            <li><strong>Email Validation:</strong> Uses PHP's FILTER_VALIDATE_EMAIL</li>
            <li><strong>Phone Validation:</strong> Custom regex pattern for international numbers</li>
            <li><strong>URL Validation:</strong> Uses PHP's FILTER_VALIDATE_URL</li>
            <li><strong>Password Strength:</strong> Minimum 8 characters with uppercase, lowercase, and number</li>
            <li><strong>Age Verification:</strong> Must be 18+ years old</li>
            <li><strong>Password Confirmation:</strong> Ensures passwords match</li>
            <li><strong>Terms Acceptance:</strong> Checkbox validation</li>
        </ul>
    </div>
</body>
</html>
