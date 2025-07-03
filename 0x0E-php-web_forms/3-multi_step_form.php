<?php
/**
 * Multi-Step Form Implementation
 * 
 * This file demonstrates how to create a multi-step form using PHP sessions
 * to maintain state across different form steps. The form includes:
 * - Personal Information (Step 1)
 * - Contact Details (Step 2)
 * - Preferences (Step 3)
 * - Review & Submit (Step 4)
 * 
 * Key concepts covered:
 * - Session management for form state
 * - Progressive form validation
 * - Step navigation (next/previous)
 * - Data persistence across steps
 * - Form completion tracking
 * 
 * Usage: Access this file via web browser and follow the form steps
 * 
 * @author Alpha0-1
 */

// Start session to maintain form state across steps
session_start();

/**
 * Initialize form data structure if not exists
 */
if (!isset($_SESSION['form_data'])) {
    $_SESSION['form_data'] = [
        'step' => 1,
        'personal' => [],
        'contact' => [],
        'preferences' => [],
        'completed' => false
    ];
}

/**
 * Form configuration - defines all form steps
 */
$form_steps = [
    1 => 'Personal Information',
    2 => 'Contact Details', 
    3 => 'Preferences',
    4 => 'Review & Submit'
];

$current_step = $_SESSION['form_data']['step'];
$errors = [];
$success_message = '';

/**
 * Process form submission based on current step
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'next':
            $errors = validateCurrentStep($current_step, $_POST);
            if (empty($errors)) {
                saveStepData($current_step, $_POST);
                if ($current_step < count($form_steps)) {
                    $_SESSION['form_data']['step']++;
                    $current_step = $_SESSION['form_data']['step'];
                }
            }
            break;
            
        case 'previous':
            if ($current_step > 1) {
                $_SESSION['form_data']['step']--;
                $current_step = $_SESSION['form_data']['step'];
            }
            break;
            
        case 'submit':
            // Final validation of all steps
            $all_errors = validateAllSteps();
            if (empty($all_errors)) {
                $success_message = processFormSubmission();
                $_SESSION['form_data']['completed'] = true;
            } else {
                $errors = $all_errors;
            }
            break;
            
        case 'reset':
            resetForm();
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
    }
}

/**
 * Validate data for current step
 * 
 * @param int $step Current form step
 * @param array $data Posted form data
 * @return array Array of validation errors
 */
function validateCurrentStep($step, $data) {
    $errors = [];
    
    switch ($step) {
        case 1: // Personal Information
            if (empty($data['first_name'])) {
                $errors[] = 'First name is required';
            }
            if (empty($data['last_name'])) {
                $errors[] = 'Last name is required';
            }
            if (empty($data['birth_date'])) {
                $errors[] = 'Birth date is required';
            } elseif (!isValidDate($data['birth_date'])) {
                $errors[] = 'Please enter a valid birth date';
            }
            if (empty($data['gender'])) {
                $errors[] = 'Please select your gender';
            }
            break;
            
        case 2: // Contact Details
            if (empty($data['email'])) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address';
            }
            if (empty($data['phone'])) {
                $errors[] = 'Phone number is required';
            } elseif (!preg_match('/^[\d\s\-\+\(\)]{10,}$/', $data['phone'])) {
                $errors[] = 'Please enter a valid phone number';
            }
            if (empty($data['address'])) {
                $errors[] = 'Address is required';
            }
            if (empty($data['city'])) {
                $errors[] = 'City is required';
            }
            if (empty($data['country'])) {
                $errors[] = 'Country is required';
            }
            break;
            
        case 3: // Preferences
            if (empty($data['interests'])) {
                $errors[] = 'Please select at least one interest';
            }
            if (empty($data['newsletter'])) {
                $errors[] = 'Please choose newsletter preference';
            }
            break;
    }
    
    return $errors;
}

/**
 * Validate all form steps for final submission
 * 
 * @return array Array of validation errors from all steps
 */
function validateAllSteps() {
    $errors = [];
    
    // Validate step 1 data
    if (empty($_SESSION['form_data']['personal'])) {
        $errors[] = 'Personal information is incomplete';
    }
    
    // Validate step 2 data
    if (empty($_SESSION['form_data']['contact'])) {
        $errors[] = 'Contact information is incomplete';
    }
    
    // Validate step 3 data
    if (empty($_SESSION['form_data']['preferences'])) {
        $errors[] = 'Preferences are incomplete';
    }
    
    return $errors;
}

/**
 * Save step data to session
 * 
 * @param int $step Current step number
 * @param array $data Form data to save
 */
function saveStepData($step, $data) {
    switch ($step) {
        case 1:
            $_SESSION['form_data']['personal'] = [
                'first_name' => sanitizeInput($data['first_name']),
                'last_name' => sanitizeInput($data['last_name']),
                'birth_date' => sanitizeInput($data['birth_date']),
                'gender' => sanitizeInput($data['gender'])
            ];
            break;
            
        case 2:
            $_SESSION['form_data']['contact'] = [
                'email' => sanitizeInput($data['email']),
                'phone' => sanitizeInput($data['phone']),
                'address' => sanitizeInput($data['address']),
                'city' => sanitizeInput($data['city']),
                'country' => sanitizeInput($data['country'])
            ];
            break;
            
        case 3:
            $_SESSION['form_data']['preferences'] = [
                'interests' => isset($data['interests']) ? $data['interests'] : [],
                'newsletter' => sanitizeInput($data['newsletter']),
                'comments' => sanitizeInput($data['comments'] ?? '')
            ];
            break;
    }
}

/**
 * Process final form submission
 * 
 * @return string Success message
 */
function processFormSubmission() {
    // In a real application, you would:
    // 1. Save data to database
    // 2. Send confirmation email
    // 3. Log the submission
    // 4. Generate user account, etc.
    
    $form_data = $_SESSION['form_data'];
    
    // Simulate processing (you could save to database here)
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'personal' => $form_data['personal'],
        'contact' => $form_data['contact'],
        'preferences' => $form_data['preferences']
    ];
    
    // Log to file (in production, use proper logging)
    file_put_contents('form_submissions.log', 
        json_encode($log_entry) . "\n", FILE_APPEND | LOCK_EX);
    
    return 'Thank you! Your registration has been completed successfully.';
}

/**
 * Reset form to initial state
 */
function resetForm() {
    unset($_SESSION['form_data']);
}

/**
 * Sanitize input data
 * 
 * @param string $input Raw input data
 * @return string Sanitized input
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate date format
 * 
 * @param string $date Date string to validate
 * @return bool True if valid date
 */
function isValidDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Get saved data for current step
 * 
 * @param int $step Step number
 * @return array Saved data for the step
 */
function getStepData($step) {
    switch ($step) {
        case 1:
            return $_SESSION['form_data']['personal'] ?? [];
        case 2:
            return $_SESSION['form_data']['contact'] ?? [];
        case 3:
            return $_SESSION['form_data']['preferences'] ?? [];
        default:
            return [];
    }
}

/**
 * Check if step is completed
 * 
 * @param int $step Step number to check
 * @return bool True if step is completed
 */
function isStepCompleted($step) {
    $data = getStepData($step);
    return !empty($data);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Step Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #4CAF50;
            transition: width 0.3s ease;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .step {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin: 0 5px;
            font-weight: bold;
        }
        .step.active {
            background-color: #4CAF50;
            color: white;
        }
        .step.completed {
            background-color: #2196F3;
            color: white;
        }
        .step.inactive {
            background-color: #e0e0e0;
            color: #666;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .checkbox-item input {
            width: auto;
        }
        .radio-group {
            display: flex;
            gap: 20px;
        }
        .radio-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .radio-item input {
            width: auto;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .success {
            color: #28a745;
            font-size: 16px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #d4edda;
            border-radius: 4px;
        }
        .review-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .review-section h3 {
            margin-top: 0;
            color: #495057;
        }
        .review-item {
            margin-bottom: 10px;
        }
        .review-item strong {
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Multi-Step Registration Form</h1>
        
        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress-fill" style="width: <?php echo ($current_step / count($form_steps)) * 100; ?>%"></div>
        </div>
        
        <!-- Step Indicator -->
        <div class="step-indicator">
            <?php foreach ($form_steps as $step_num => $step_name): ?>
                <div class="step <?php 
                    if ($step_num == $current_step) {
                        echo 'active';
                    } elseif ($step_num < $current_step || isStepCompleted($step_num)) {
                        echo 'completed';
                    } else {
                        echo 'inactive';
                    }
                ?>">
                    <?php echo $step_num . '. ' . $step_name; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Success Message -->
        <?php if (!empty($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <!-- Form Content -->
        <?php if (!$_SESSION['form_data']['completed']): ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <?php
                $step_data = getStepData($current_step);
                
                switch ($current_step):
                    case 1: // Personal Information
                ?>
                    <h2>Step 1: Personal Information</h2>
                    
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" 
                               value="<?php echo $step_data['first_name'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" 
                               value="<?php echo $step_data['last_name'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="birth_date">Birth Date *</label>
                        <input type="date" id="birth_date" name="birth_date" 
                               value="<?php echo $step_data['birth_date'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Gender *</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="male" name="gender" value="male" 
                                       <?php echo (($step_data['gender'] ?? '') == 'male') ? 'checked' : ''; ?>>
                                <label for="male">Male</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="female" name="gender" value="female" 
                                       <?php echo (($step_data['gender'] ?? '') == 'female') ? 'checked' : ''; ?>>
                                <label for="female">Female</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="other" name="gender" value="other" 
                                       <?php echo (($step_data['gender'] ?? '') == 'other') ? 'checked' : ''; ?>>
                                <label for="other">Other</label>
                            </div>
                        </div>
                    </div>
                    
                <?php break;
                    case 2: // Contact Details
                ?>
                    <h2>Step 2: Contact Details</h2>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo $step_data['email'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?php echo $step_data['phone'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address *</label>
                        <input type="text" id="address" name="address" 
                               value="<?php echo $step_data['address'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City *</label>
                        <input type="text" id="city" name="city" 
                               value="<?php echo $step_data['city'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Country *</label>
                        <select id="country" name="country" required>
                            <option value="">Select Country</option>
                            <option value="US" <?php echo (($step_data['country'] ?? '') == 'US') ? 'selected' : ''; ?>>United States</option>
                            <option value="CA" <?php echo (($step_data['country'] ?? '') == 'CA') ? 'selected' : ''; ?>>Canada</option>
                            <option value="UK" <?php echo (($step_data['country'] ?? '') == 'UK') ? 'selected' : ''; ?>>United Kingdom</option>
                            <option value="DE" <?php echo (($step_data['country'] ?? '') == 'DE') ? 'selected' : ''; ?>>Germany</option>
                            <option value="FR" <?php echo (($step_data['country'] ?? '') == 'FR') ? 'selected' : ''; ?>>France</option>
                            <option value="AU" <?php echo (($step_data['country'] ?? '') == 'AU') ? 'selected' : ''; ?>>Australia</option>
                        </select>
                    </div>
                    
                <?php break;
                    case 3: // Preferences
                ?>
                    <h2>Step 3: Preferences</h2>
                    
                    <div class="form-group">
                        <label>Interests * (Select all that apply)</label>
                        <div class="checkbox-group">
                            <?php
                            $interests = ['Technology', 'Sports', 'Music', 'Travel', 'Food', 'Art', 'Science', 'Literature'];
                            $selected_interests = $step_data['interests'] ?? [];
                            foreach ($interests as $interest):
                            ?>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="<?php echo strtolower($interest); ?>" 
                                           name="interests[]" value="<?php echo $interest; ?>"
                                           <?php echo in_array($interest, $selected_interests) ? 'checked' : ''; ?>>
                                    <label for="<?php echo strtolower($interest); ?>"><?php echo $interest; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Newsletter Subscription *</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="weekly" name="newsletter" value="weekly" 
                                       <?php echo (($step_data['newsletter'] ?? '') == 'weekly') ? 'checked' : ''; ?>>
                                <label for="weekly">Weekly</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="monthly" name="newsletter" value="monthly" 
                                       <?php echo (($step_data['newsletter'] ?? '') == 'monthly') ? 'checked' : ''; ?>>
                                <label for="monthly">Monthly</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="never" name="newsletter" value="never" 
                                       <?php echo (($step_data['newsletter'] ?? '') == 'never') ? 'checked' : ''; ?>>
                                <label for="never">Never</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="comments">Additional Comments</label>
                        <textarea id="comments" name="comments" 
                                  placeholder="Any additional information..."><?php echo $step_data['comments'] ?? ''; ?></textarea>
                    </div>
                    
                <?php break;
                    case 4: // Review & Submit
                ?>
                    <h2>Step 4: Review & Submit</h2>
                    
                    <div class="review-section">
                        <h3>Personal Information</h3>
                        <?php $personal = $_SESSION['form_data']['personal']; ?>
                        <div class="review-item">
                            <strong>Name:</strong> <?php echo $personal['first_name'] . ' ' . $personal['last_name']; ?>
                        </div>
                        <div class="review-item">
                            <strong>Birth Date:</strong> <?php echo $personal['birth_date']; ?>
                        </div>
                        <div class="review-item">
                            <strong>Gender:</strong> <?php echo ucfirst($personal['gender']); ?>
                        </div>
                    </div>
                    
                    <div class="review-section">
                        <h3>Contact Details</h3>
                        <?php $contact = $_SESSION['form_data']['contact']; ?>
                        <div class="review-item">
                            <strong>Email:</strong> <?php echo $contact['email']; ?>
                        </div>
                        <div class="review-item">
                            <strong>Phone:</strong> <?php echo $contact['phone']; ?>
                        </div>
                        <div class="review-item">
                            <strong>Address:</strong> <?php echo $contact['address']; ?>
                        </div>
                        <div class="review-item">
                            <strong>City:</strong> <?php echo $contact['city']; ?>
                        </div>
                        <div class="review-item">
                            <strong>Country:</strong> <?php echo $contact['country']; ?>
                        </div>
                    </div>
                    
                    <div class="review-section">
                        <h3>Preferences</h3>
                        <?php $preferences = $_SESSION['form_data']['preferences']; ?>
                        <div class="review-item">
                            <strong>Interests:</strong> <?php echo implode(', ', $preferences['interests']); ?>
                        </div>
                        <div class="review-item">
                            <strong>Newsletter:</strong> <?php echo ucfirst($preferences['newsletter']); ?>
                        </div>
                        <?php if (!empty($preferences['comments'])): ?>
                            <div class="review-item">
                                <strong>Comments:</strong> <?php echo $preferences['comments']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                <?php break;
                endswitch; ?>
                
                <!-- Navigation Buttons -->
                <div class="button-group">
                    <div>
                        <?php if ($current_step > 1): ?>
                            <button type="submit" name="action" value="previous" class="btn btn-secondary">
                                « Previous
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <?php if ($current_step < count($form_steps)): ?>
                            <button type="submit" name="action" value="next" class="btn btn-primary">
                                Next »
                            </button>
                        <?php else: ?>
                            <button type="submit" name="action" value="submit" class="btn btn-primary">
                                Submit Registration
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <!-- Form Completed -->
            <div class="text-center">
                <h2>Registration Completed!</h2>
                <p>Thank you for your registration. We'll be in touch soon.</p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <button type="submit" name="action" value="reset" class="btn btn-danger">
                        Start New Registration
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
